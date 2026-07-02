<?php

namespace App\Services;

use App\Models\ExtractedItem;
use App\Models\Supplier;
use App\Models\Work;

/**
 * Gera o texto técnico de e-mail de solicitação de cotação para itens
 * sob medida (esquadrias minimalistas, pedras naturais, marcenaria fina etc.).
 *
 * Geração determinística por template (não depende de API externa). Caso um
 * arquivo de prompt exista, ele é usado como cabeçalho de orientação.
 */
class QuoteEmailService
{
    /**
     * Categorias/itens que exigem cotação formal.
     */
    public const REQUIRES_FORMAL_QUOTE = [
        'esquadrias minimalistas', 'vidros jumbo', 'pedras naturais especiais',
        'mármores importados', 'marcenaria fina', 'serralheria fina',
        'guarda-corpos especiais', 'brises sob medida', 'pisos monolíticos',
        'microcimento', 'automação', 'climatização VRF/VRV', 'luminárias importadas',
        'elevadores', 'paisagismo técnico',
    ];

    public function requiresFormalQuote(ExtractedItem $item): bool
    {
        if ($item->requires_specific_quote) {
            return true;
        }

        $haystack = mb_strtolower(
            trim("{$item->item_identified} {$item->category} {$item->subcategory} {$item->technical_description}")
        );

        foreach (self::REQUIRES_FORMAL_QUOTE as $needle) {
            if (str_contains($haystack, mb_strtolower($needle))) {
                return true;
            }
        }

        return false;
    }

    public function subjectFor(Work $work, ExtractedItem $item): string
    {
        return "Solicitação de cotação técnica - {$item->item_identified} - Obra {$work->name}";
    }

    public function buildBody(Work $work, ExtractedItem $item, ?Supplier $supplier = null): string
    {
        $ni = 'não identificado';
        $saudacao = $supplier && $supplier->contact_name
            ? "Prezado(a) {$supplier->contact_name},"
            : 'Prezados(as),';

        $header = $this->promptHeader();

        $lines = [];
        $lines[] = $saudacao;
        $lines[] = '';
        $lines[] = "Solicitamos cotação técnica formal para o item abaixo, referente à obra residencial de alto padrão \"{$work->name}\""
            . ($work->city ? " ({$work->city}/{$work->state})" : '') . '.';
        $lines[] = '';
        $lines[] = 'DADOS DO ITEM';
        $lines[] = "- Item: {$item->item_identified}";
        $lines[] = "- Categoria: " . ($item->category ?: $ni);
        $lines[] = "- Ambiente: " . ($item->environment ?: $ni);
        $lines[] = "- Descrição técnica: " . ($item->technical_description ?: $ni);
        $lines[] = "- Unidade sugerida: " . ($item->suggested_unit ?: $ni);
        $lines[] = "- Quantidade identificada: " . ($item->identified_quantity ?: $ni);
        $lines[] = "- Padrão de acabamento: " . ($item->finish_standard ?: $ni);
        $lines[] = '';
        $lines[] = 'INFORMAÇÕES SOLICITADAS';
        $lines[] = '- Preço unitário e unidade de medida;';
        $lines[] = '- Impostos inclusos ou não;';
        $lines[] = '- Frete incluso ou não;';
        $lines[] = '- Prazo de entrega e validade da proposta;';
        $lines[] = '- Especificações técnicas completas (material, acabamento, dimensões, tolerâncias);';
        $lines[] = '- Necessidade de medição em obra, mockup ou projeto executivo específico;';
        $lines[] = '- Condições de içamento/logística especial, se aplicável.';

        if (! empty(trim((string) $item->specification_gaps)) && $item->specification_gaps !== $ni) {
            $lines[] = '';
            $lines[] = 'LACUNAS DE ESPECIFICAÇÃO A ESCLARECER';
            $lines[] = $item->specification_gaps;
        }

        $lines[] = '';
        $lines[] = 'Observação: este item exige validação técnica humana. Nenhuma especificação foi assumida além do memorial descritivo.';
        $lines[] = '';
        $lines[] = 'Atenciosamente,';
        $lines[] = 'Departamento de Orçamentos';
        $lines[] = 'O rigor da engenharia para a arte da arquitetura';

        $body = implode("\n", $lines);

        return $header ? ($header . "\n\n" . $body) : $body;
    }

    protected function promptHeader(): string
    {
        $path = resource_path('prompts/quote_email_prompt.txt');
        if (is_file($path)) {
            $content = trim(file_get_contents($path));
            // O arquivo é orientação interna; não incluímos no corpo final do e-mail,
            // apenas o utilizamos como guia. Retornamos vazio para o corpo do cliente.
            return '';
        }

        return '';
    }
}
