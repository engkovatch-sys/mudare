<?php

namespace App\Services;

use App\Models\Work;
use Illuminate\Support\Facades\Storage;

/**
 * Exportação CSV (itens, preços, alertas, proposta resumida).
 *
 * Não depende de storage:link. O download é feito via controller com
 * response()->download() a partir do disco local.
 */
class CsvExportService
{
    /**
     * Gera um CSV para a obra e retorna o caminho relativo no disco local.
     */
    public function export(Work $work, string $type): string
    {
        [$header, $rows] = match ($type) {
            'items' => $this->items($work),
            'prices' => $this->prices($work),
            'alerts' => $this->alerts($work),
            'proposal' => $this->proposalSummary($work),
            default => $this->items($work),
        };

        $filename = 'exports/obra_' . $work->id . '_' . $type . '_' . now()->format('Ymd_His') . '.csv';

        $handle = fopen('php://temp', 'r+');
        // BOM para acentuação correta no Excel.
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, array_map([$this, 'sanitize'], $header), ';');
        foreach ($rows as $row) {
            fputcsv($handle, array_map([$this, 'sanitize'], $row), ';');
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        Storage::disk('local')->put($filename, $csv);

        return $filename;
    }

    /**
     * Neutraliza CSV formula injection: células que começam com =, +, -, @
     * (ou tab/CR seguidos desses) são interpretadas como fórmula por
     * Excel/Sheets. Prefixamos com apóstrofo para forçar texto.
     */
    protected function sanitize($value): string
    {
        $value = (string) $value;

        if ($value === '') {
            return $value;
        }

        if (preg_match('/^[\t\r]*[=+\-@]/', $value)) {
            return "'" . $value;
        }

        return $value;
    }

    protected function items(Work $work): array
    {
        $header = [
            'ID', 'Item', 'Categoria', 'Subcategoria', 'Ambiente', 'Descrição',
            'Unidade', 'Quantidade', 'Impacto', 'Criticidade', 'Padrão',
            'Exige cotação', 'Confiança', 'Status validação', 'Página',
        ];

        $rows = $work->extractedItems()->get()->map(fn ($i) => [
            $i->id, $i->item_identified, $i->category, $i->subcategory, $i->environment,
            $i->technical_description, $i->suggested_unit, $i->identified_quantity,
            $i->budget_impact, $i->criticality, $i->finish_standard,
            $i->requires_specific_quote ? 'Sim' : 'Não', $i->confidence_score,
            $i->validation_status, $i->source_page,
        ])->all();

        return [$header, $rows];
    }

    protected function prices(Work $work): array
    {
        $header = [
            'ID', 'Fornecedor', 'Item', 'Categoria', 'Unidade', 'Preço unitário',
            'Tipo', 'Fonte', 'URL', 'Coletado em', 'Validade', 'Impostos inclusos',
            'Frete incluso', 'Responsável validação', 'Status validação',
        ];

        $rows = \App\Models\Price::with('supplier')->get()->map(fn ($p) => [
            $p->id, optional($p->supplier)->name, $p->item_name, $p->category, $p->unit,
            number_format((float) $p->unit_price, 2, ',', '.'), $p->price_type, $p->source,
            $p->source_url, optional($p->collected_at)->format('d/m/Y'),
            optional($p->valid_until)->format('d/m/Y'),
            $p->taxes_included ? 'Sim' : 'Não', $p->freight_included ? 'Sim' : 'Não',
            $p->validation_responsible, $p->validation_status,
        ])->all();

        return [$header, $rows];
    }

    protected function alerts(Work $work): array
    {
        $header = [
            'ID', 'Tipo', 'Severidade', 'Categoria', 'Ambiente', 'Descrição',
            'Valor atual', 'Valor referência', 'Desvio %', 'Ação recomendada',
        ];

        $rows = $work->alerts()->get()->map(fn ($a) => [
            $a->id, $a->alert_type, $a->severity instanceof \BackedEnum ? $a->severity->value : $a->severity,
            $a->category, $a->environment, $a->description, $a->current_value,
            $a->reference_value, $a->deviation_percentage, $a->recommended_action,
        ])->all();

        return [$header, $rows];
    }

    protected function proposalSummary(Work $work): array
    {
        $header = ['Obra', 'Cliente', 'Arquiteto', 'Itens totais', 'Itens aprovados', 'Alertas abertos', 'Propostas geradas'];

        $rows = [[
            $work->name,
            optional($work->client)->name,
            optional($work->architect)->name,
            $work->extractedItems()->count(),
            $work->extractedItems()->where('validation_status', 'approved')->count(),
            $work->alerts()->whereNull('resolved_at')->count(),
            $work->proposals()->count(),
        ]];

        return [$header, $rows];
    }
}
