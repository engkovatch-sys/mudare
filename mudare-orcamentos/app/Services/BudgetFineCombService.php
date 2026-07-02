<?php

namespace App\Services;

use App\Models\BudgetAlert;
use App\Models\BudgetHistory;
use App\Models\ExtractedItem;
use App\Models\Price;
use App\Models\Work;
use Illuminate\Support\Str;

/**
 * Malha fina orçamentária.
 *
 * Cruza os itens extraídos da obra com o histórico orçamentário e regras
 * técnicas de obras de alto padrão, gerando alertas classificados por
 * severidade. NÃO substitui o engenheiro orçamentista — sinaliza riscos.
 */
class BudgetFineCombService
{
    /**
     * Itens típicos de alto padrão que devem ser checados quanto à presença.
     */
    public const TYPICAL_ITEMS = [
        'impermeabilização de floreiras', 'impermeabilização de piscinas', 'drenagem',
        'ralos lineares', 'proteção mecânica', 'juntas', 'regularização de base',
        'esquadrias especiais', 'guarda-corpos', 'pedras naturais', 'marcenaria',
        'automação', 'climatização', 'luminotécnica', 'paisagismo técnico',
        'limpeza fina', 'proteção de piso', 'fretes especiais', 'içamentos', 'mockups',
        'gerenciamento técnico', 'projetos complementares', 'art/rrt',
    ];

    protected const LOW_CONFIDENCE_THRESHOLD = 50;
    protected const PRICE_LOWER_BOUND = 0.85; // abaixo de 85% do histórico
    protected const PRICE_UPPER_BOUND = 1.15; // acima de 115% do histórico

    public function __construct(protected UnitNormalizerService $units)
    {
    }

    /**
     * Executa a malha fina para uma obra e persiste os alertas.
     *
     * @return array{alerts_created: int, resumo: array<string,int>}
     */
    public function run(Work $work): array
    {
        // Regenera: remove alertas não resolvidos anteriores.
        BudgetAlert::where('work_id', $work->id)->whereNull('resolved_at')->delete();

        $items = $work->extractedItems()->get();
        $alerts = [];

        $alerts = array_merge($alerts, $this->checkMissingTypicalItems($work, $items));

        foreach ($items as $item) {
            $alerts = array_merge($alerts, $this->checkItem($work, $item));
        }

        $resumo = [
            'informativo' => 0, 'baixo' => 0, 'medio' => 0, 'alto' => 0, 'critico' => 0,
        ];

        foreach ($alerts as $alert) {
            BudgetAlert::create($alert);
            $sev = $alert['severity'];
            $resumo[$sev] = ($resumo[$sev] ?? 0) + 1;
        }

        return [
            'alerts_created' => count($alerts),
            'resumo' => $resumo,
        ];
    }

    /**
     * @param  \Illuminate\Support\Collection<int, ExtractedItem>  $items
     * @return array<int, array>
     */
    protected function checkMissingTypicalItems(Work $work, $items): array
    {
        $alerts = [];

        $haystack = mb_strtolower($items->map(function (ExtractedItem $i) {
            return "{$i->item_identified} {$i->category} {$i->subcategory} {$i->technical_description}";
        })->implode(' '));

        foreach (self::TYPICAL_ITEMS as $typical) {
            $needle = mb_strtolower($typical);
            $token = Str::of($needle)->explode(' ')->first();

            if (! str_contains($haystack, $needle) && ! str_contains($haystack, $token)) {
                $alerts[] = [
                    'work_id' => $work->id,
                    'extracted_item_id' => null,
                    'alert_type' => 'item_tipico_ausente',
                    'description' => "Item típico de alto padrão possivelmente ausente do orçamento: \"{$typical}\".",
                    'severity' => 'medio',
                    'category' => $typical,
                    'environment' => null,
                    'current_value' => 'ausente',
                    'reference_value' => 'esperado em obra de alto padrão',
                    'deviation_percentage' => null,
                    'evidence' => 'Nenhuma menção encontrada nos itens extraídos.',
                    'recommended_action' => 'Verificar com o engenheiro orçamentista se o item se aplica à obra e, em caso positivo, incluí-lo.',
                    'human_validation_required' => true,
                ];
            }
        }

        return $alerts;
    }

    /**
     * @return array<int, array>
     */
    protected function checkItem(Work $work, ExtractedItem $item): array
    {
        $alerts = [];
        $base = [
            'work_id' => $work->id,
            'extracted_item_id' => $item->id,
            'category' => $item->category,
            'environment' => $item->environment,
            'human_validation_required' => true,
        ];

        // 1. Item sem validação humana (pending / needs_revision).
        if (in_array($item->validation_status, ['pending', 'needs_revision'], true)) {
            $sev = ($item->criticality === 'critica') ? 'critico' : 'alto';
            $alerts[] = $base + [
                'alert_type' => 'item_sem_validacao',
                'description' => "Item \"{$item->item_identified}\" ainda não validado (status: {$item->validation_status}).",
                'severity' => $sev,
                'current_value' => $item->validation_status,
                'reference_value' => 'approved',
                'deviation_percentage' => null,
                'evidence' => 'Item gerado pela IA exige revisão humana antes de compor a proposta.',
                'recommended_action' => 'Revisar, corrigir e aprovar/rejeitar o item.',
            ];
        }

        // 2. Item crítico pendente (reforço explícito).
        if ($item->criticality === 'critica' && $item->validation_status !== 'approved') {
            $alerts[] = $base + [
                'alert_type' => 'item_critico_pendente',
                'description' => "Item CRÍTICO \"{$item->item_identified}\" não aprovado.",
                'severity' => 'critico',
                'current_value' => $item->validation_status,
                'reference_value' => 'approved',
                'deviation_percentage' => null,
                'evidence' => 'Itens críticos não aprovados representam risco direto à obra.',
                'recommended_action' => 'Priorizar validação técnica deste item.',
            ];
        }

        // 3. Item sem evidência textual.
        if (blank($item->textual_evidence) || $item->textual_evidence === 'não identificado') {
            $alerts[] = $base + [
                'alert_type' => 'sem_evidencia_textual',
                'description' => "Item \"{$item->item_identified}\" sem evidência textual no memorial.",
                'severity' => 'alto',
                'current_value' => 'sem evidência',
                'reference_value' => 'evidência textual obrigatória',
                'deviation_percentage' => null,
                'evidence' => 'Item sem trecho de origem no memorial pode ter sido inferido indevidamente.',
                'recommended_action' => 'Confirmar a origem do item no memorial descritivo.',
            ];
        }

        // 4. Baixa confiança.
        if ($item->confidence_score > 0 && $item->confidence_score < self::LOW_CONFIDENCE_THRESHOLD) {
            $alerts[] = $base + [
                'alert_type' => 'baixa_confianca',
                'description' => "Item \"{$item->item_identified}\" com baixa confiança ({$item->confidence_score}%).",
                'severity' => 'medio',
                'current_value' => "{$item->confidence_score}%",
                'reference_value' => '>= ' . self::LOW_CONFIDENCE_THRESHOLD . '%',
                'deviation_percentage' => null,
                'evidence' => 'Confiança baixa da extração automática.',
                'recommended_action' => 'Revisar manualmente a descrição técnica e a quantidade.',
            ];
        }

        // 5. Exige cotação específica e não possui cotação.
        if ($item->requires_specific_quote && $item->quoteRequests()->count() === 0) {
            $alerts[] = $base + [
                'alert_type' => 'sem_cotacao_formal',
                'description' => "Item \"{$item->item_identified}\" exige cotação formal e não possui solicitação registrada.",
                'severity' => 'alto',
                'current_value' => 'sem cotação',
                'reference_value' => 'cotação formal necessária',
                'deviation_percentage' => null,
                'evidence' => 'Item sob medida sem cotação pode gerar desvio orçamentário relevante.',
                'recommended_action' => 'Gerar e enviar solicitação de cotação ao fornecedor.',
            ];
        }

        // 6. Especificação com lacunas.
        if (filled($item->specification_gaps) && $item->specification_gaps !== 'não identificado') {
            $alerts[] = $base + [
                'alert_type' => 'lacuna_especificacao',
                'description' => "Item \"{$item->item_identified}\" possui lacunas de especificação.",
                'severity' => 'medio',
                'current_value' => 'lacunas presentes',
                'reference_value' => 'especificação completa',
                'deviation_percentage' => null,
                'evidence' => (string) $item->specification_gaps,
                'recommended_action' => 'Solicitar complemento de especificação ao arquiteto/cliente.',
            ];
        }

        // 7. Comparação de preço com histórico (se houver preço cadastrado).
        $alerts = array_merge($alerts, $this->checkPriceAgainstHistory($work, $item, $base));

        return $alerts;
    }

    /**
     * @return array<int, array>
     */
    protected function checkPriceAgainstHistory(Work $work, ExtractedItem $item, array $base): array
    {
        $alerts = [];

        $price = Price::query()
            ->where(function ($q) use ($item) {
                $q->where('item_name', 'like', '%' . Str::limit($item->item_identified, 30, '') . '%')
                  ->orWhere('category', $item->category);
            })
            ->orderByDesc('collected_at')
            ->first();

        if (! $price) {
            return $alerts;
        }

        // Preço estimado é sempre sinalizado.
        if ($price->price_type === 'estimado') {
            $alerts[] = $base + [
                'alert_type' => 'preco_estimado',
                'description' => "Item \"{$item->item_identified}\" usa preço ESTIMADO (não pode ser tratado como final sem validação).",
                'severity' => 'medio',
                'current_value' => 'estimado',
                'reference_value' => 'cotado/referencial validado',
                'deviation_percentage' => null,
                'evidence' => "Preço id {$price->id} do tipo estimado.",
                'recommended_action' => 'Validar o preço com cotação formal antes do fechamento.',
            ];
        }

        $history = BudgetHistory::query()
            ->where(function ($q) use ($item) {
                $q->where('category', $item->category)
                  ->orWhere('item_name', 'like', '%' . Str::limit($item->item_identified, 30, '') . '%');
            })
            ->orderByDesc('base_date')
            ->first();

        if ($history && (float) $history->unit_price > 0 && (float) $price->unit_price > 0) {
            $ratio = (float) $price->unit_price / (float) $history->unit_price;
            $deviation = round(($ratio - 1) * 100, 2);

            if ($ratio < self::PRICE_LOWER_BOUND) {
                $alerts[] = $base + [
                    'alert_type' => 'preco_abaixo_historico',
                    'description' => "Preço de \"{$item->item_identified}\" abaixo de 85% do histórico (possível subdimensionamento).",
                    'severity' => 'alto',
                    'current_value' => 'R$ ' . number_format((float) $price->unit_price, 2, ',', '.'),
                    'reference_value' => 'R$ ' . number_format((float) $history->unit_price, 2, ',', '.'),
                    'deviation_percentage' => $deviation,
                    'evidence' => "Preço cadastrado {$deviation}% em relação ao histórico.",
                    'recommended_action' => 'Revisar composição de custo; risco de escopo incompleto.',
                ];
            } elseif ($ratio > self::PRICE_UPPER_BOUND) {
                $alerts[] = $base + [
                    'alert_type' => 'preco_acima_historico',
                    'description' => "Preço de \"{$item->item_identified}\" acima de 115% do histórico.",
                    'severity' => 'medio',
                    'current_value' => 'R$ ' . number_format((float) $price->unit_price, 2, ',', '.'),
                    'reference_value' => 'R$ ' . number_format((float) $history->unit_price, 2, ',', '.'),
                    'deviation_percentage' => $deviation,
                    'evidence' => "Preço cadastrado {$deviation}% em relação ao histórico.",
                    'recommended_action' => 'Confirmar especificação premium ou renegociar.',
                ];
            }
        }

        return $alerts;
    }
}
