<?php

namespace App\Services;

use App\Models\ExtractedItem;
use App\Models\Memorial;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Serviço central de extração orçamentária via API Anthropic (Claude).
 *
 * Regras de segurança/qualidade:
 *  - Nunca expõe a chave em tela ou log.
 *  - Se a chave não estiver configurada, retorna mensagem amigável.
 *  - Nenhuma especificação é inventada: itens sem dado recebem "não identificado".
 *  - Todo item nasce com validation_status = pending (revisão humana obrigatória).
 */
class AnthropicExtractionService
{
    public function __construct(
        protected ChunkingService $chunker,
        protected ExtractionConsolidatorService $consolidator,
    ) {
    }

    public function isConfigured(): bool
    {
        return filled(config('anthropic.api_key'));
    }

    /**
     * Processa um memorial: chunk -> Anthropic -> JSON -> itens (pending).
     *
     * @return array{success: bool, message: string, items_created?: int}
     */
    public function processMemorial(Memorial $memorial): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'API Anthropic não configurada. Verifique o arquivo .env.',
            ];
        }

        $text = $memorial->effectiveText();

        if (trim($text) === '') {
            return [
                'success' => false,
                'message' => 'Memorial sem texto. Faça upload do PDF ou cole o texto manualmente.',
            ];
        }

        $systemPrompt = $this->systemPrompt();
        $chunks = $this->chunker->chunk($text);
        $allItems = [];
        $rawPayloads = [];

        foreach ($chunks as $index => $chunk) {
            try {
                $result = $this->callApi($systemPrompt, $chunk, $index + 1, count($chunks));
            } catch (\Throwable $e) {
                Log::error('Erro na chamada Anthropic', ['message' => $e->getMessage()]);

                return [
                    'success' => false,
                    'message' => 'Erro ao comunicar com a API Anthropic. Verifique a chave, o modelo e a conexão.',
                ];
            }

            if (! $result['success']) {
                return ['success' => false, 'message' => $result['message']];
            }

            $rawPayloads[] = $result['raw'];
            foreach ($result['items'] as $item) {
                $allItems[] = $item;
            }
        }

        $consolidated = $this->consolidator->consolidate($allItems);

        // Remove itens antigos deste memorial para reprocessamento idempotente.
        ExtractedItem::where('memorial_id', $memorial->id)->delete();

        $created = 0;
        foreach ($consolidated as $item) {
            ExtractedItem::create($this->mapToRecord($memorial, $item));
            $created++;
        }

        return [
            'success' => true,
            'message' => "Extração concluída. {$created} item(ns) criado(s) para revisão humana (pending).",
            'items_created' => $created,
        ];
    }

    /**
     * @return array{success: bool, message?: string, items?: array, raw?: string}
     */
    protected function callApi(string $systemPrompt, string $chunk, int $part, int $total): array
    {
        $userContent = "PARTE {$part} DE {$total} DO MEMORIAL DESCRITIVO.\n\n"
            . "Extraia os itens orçamentários desta parte. Responda APENAS com JSON válido "
            . "no formato {\"items\": [ ... ]}. Não inclua texto fora do JSON.\n\n"
            . "----- INÍCIO DO TRECHO -----\n{$chunk}\n----- FIM DO TRECHO -----";

        $response = Http::withHeaders([
            'x-api-key' => config('anthropic.api_key'),
            'anthropic-version' => config('anthropic.version'),
            'content-type' => 'application/json',
        ])
            ->timeout((int) config('anthropic.timeout', 60))
            ->post(config('anthropic.base_url'), [
                'model' => config('anthropic.model'),
                'max_tokens' => (int) config('anthropic.max_tokens', 4096),
                'system' => $systemPrompt,
                'messages' => [
                    ['role' => 'user', 'content' => $userContent],
                ],
            ]);

        if ($response->failed()) {
            $status = $response->status();

            // Nunca logar corpo com chave; logamos apenas status.
            Log::warning('Anthropic respondeu com erro', ['status' => $status]);

            $friendly = match (true) {
                $status === 401 => 'Chave da API Anthropic inválida. Verifique o arquivo .env.',
                $status === 429 => 'Limite de requisições da API Anthropic atingido. Tente novamente em instantes.',
                $status >= 500 => 'A API Anthropic está indisponível no momento. Tente novamente mais tarde.',
                default => 'A API Anthropic retornou um erro ao processar o memorial.',
            };

            return ['success' => false, 'message' => $friendly];
        }

        $body = $response->json();
        $raw = $body['content'][0]['text'] ?? '';

        $items = $this->parseJsonItems($raw);

        if ($items === null) {
            return [
                'success' => false,
                'message' => 'A resposta da IA não retornou um JSON válido. Tente reprocessar o memorial.',
            ];
        }

        return ['success' => true, 'items' => $items, 'raw' => $raw];
    }

    /**
     * Extrai e valida o array de itens de uma resposta textual.
     *
     * @return array<int, array>|null
     */
    protected function parseJsonItems(string $raw): ?array
    {
        $raw = trim($raw);

        // Remove cercas de código, se houver.
        $raw = preg_replace('/^```(?:json)?/i', '', $raw);
        $raw = preg_replace('/```$/', '', trim($raw));
        $raw = trim($raw);

        // Isola o objeto/array JSON.
        $start = strpbrk($raw, '{[');
        if ($start !== false) {
            $firstBrace = strpos($raw, '{');
            $firstBracket = strpos($raw, '[');
            $positions = array_filter([$firstBrace, $firstBracket], fn ($p) => $p !== false);
            if (! empty($positions)) {
                $raw = substr($raw, min($positions));
            }
        }

        $decoded = json_decode($raw, true);

        if (! is_array($decoded)) {
            return null;
        }

        if (isset($decoded['items']) && is_array($decoded['items'])) {
            return $decoded['items'];
        }

        // Caso a IA devolva diretamente um array de itens.
        if (array_is_list($decoded)) {
            return $decoded;
        }

        // Caso devolva um único item.
        return [$decoded];
    }

    protected function mapToRecord(Memorial $memorial, array $item): array
    {
        $ni = 'não identificado';

        return [
            'work_id' => $memorial->work_id,
            'memorial_id' => $memorial->id,
            'item_identified' => $this->str($item, 'item_identified', $ni),
            'category' => $this->str($item, 'category', $ni),
            'subcategory' => $this->str($item, 'subcategory', $ni),
            'environment' => $this->str($item, 'environment', $ni),
            'technical_description' => $this->str($item, 'technical_description', $ni),
            'suggested_unit' => $this->str($item, 'suggested_unit', $ni),
            'identified_quantity' => $this->str($item, 'identified_quantity', $ni),
            'budget_impact' => $this->str($item, 'budget_impact', 'nao_identificado'),
            'criticality' => $this->str($item, 'criticality', 'nao_identificado'),
            'finish_standard' => $this->str($item, 'finish_standard', 'nao_identificado'),
            'requires_specific_quote' => (bool) ($item['requires_specific_quote'] ?? false),
            'textual_evidence' => $this->str($item, 'textual_evidence', $ni),
            'source_page' => $this->str($item, 'source_page', $ni),
            'confidence_score' => max(0, min(100, (int) ($item['confidence_score'] ?? 0))),
            'specification_gaps' => $this->str($item, 'specification_gaps', $ni),
            'human_validation_note' => $this->str($item, 'human_validation_note', ''),
            'validation_status' => 'pending', // sempre pending: revisão humana obrigatória
            'raw_payload_json' => json_encode($item, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        ];
    }

    protected function str(array $item, string $key, string $default): string
    {
        $value = $item[$key] ?? null;
        if ($value === null || (is_string($value) && trim($value) === '')) {
            return $default;
        }
        if (is_array($value)) {
            return implode('; ', array_map('strval', $value));
        }

        return (string) $value;
    }

    protected function systemPrompt(): string
    {
        $path = resource_path('prompts/system_orcamentista.txt');

        if (is_file($path)) {
            return file_get_contents($path);
        }

        return 'Você é um engenheiro orçamentista sênior. Extraia itens orçamentários em JSON válido {"items": []}.';
    }
}
