<?php

namespace App\Services;

use App\Models\Price;
use App\Models\Proposal;
use App\Models\Work;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Gera o PDF COMERCIAL (voltado ao cliente).
 *
 * Não expõe fragilidades internas da malha fina. Porém, se houver item
 * crítico pendente, o controller deve exibir alerta antes da geração.
 */
class ProposalPdfService
{
    /**
     * Verifica itens críticos pendentes (bloqueio/alerta antes de gerar).
     *
     * @return \Illuminate\Support\Collection
     */
    public function criticalPendingItems(Work $work)
    {
        return $work->extractedItems()
            ->where('validation_status', '!=', 'approved')
            ->where(function ($q) {
                $q->where('criticality', 'critica')
                  ->orWhere('requires_specific_quote', true);
            })
            ->get();
    }

    public function generate(Work $work): Proposal
    {
        $work->loadMissing(['client', 'architect']);

        $approvedItems = $work->extractedItems()
            ->where('validation_status', 'approved')
            ->orderBy('category')
            ->get();

        $composition = $this->buildCostComposition($approvedItems);
        $directCost = $composition->sum('total');

        // Custos indiretos e BDI (parâmetros comerciais padrão do MVP).
        $indirectRate = 0.08;   // 8% custos indiretos
        $adminRate = 0.10;      // 10% administração
        $bdiRate = 0.2278;      // BDI referencial

        $indirect = $directCost * $indirectRate;
        $admin = $directCost * $adminRate;
        $subtotal = $directCost + $indirect + $admin;
        $bdi = $subtotal * $bdiRate;
        $total = $subtotal + $bdi;

        $quoteItems = $work->extractedItems()
            ->where('requires_specific_quote', true)
            ->get();

        $data = [
            'work' => $work,
            'client' => $work->client,
            'architect' => $work->architect,
            'composition' => $composition,
            'directCost' => $directCost,
            'indirect' => $indirect,
            'indirectRate' => $indirectRate,
            'admin' => $admin,
            'adminRate' => $adminRate,
            'bdi' => $bdi,
            'bdiRate' => $bdiRate,
            'total' => $total,
            'quoteItems' => $quoteItems,
            'brandColor' => config('app.pdf_brand_color', env('PDF_BRAND_COLOR', '#DD5600')),
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('pdfs.commercial', $data)->setPaper('a4');

        $filename = 'proposals/comercial_obra_' . $work->id . '_' . Str::random(8) . '.pdf';
        Storage::disk('local')->put($filename, $pdf->output());

        return Proposal::create([
            'work_id' => $work->id,
            'proposal_type' => 'commercial',
            'title' => 'Proposta Comercial - ' . $work->name,
            'file_path' => $filename,
            'total_amount' => round($total, 2),
            'status' => 'generated',
            'generated_at' => now(),
            'valid_until' => $work->proposal_valid_until,
        ]);
    }

    /**
     * Monta composição de custo direto a partir dos itens aprovados,
     * buscando preço mais recente compatível.
     */
    protected function buildCostComposition($items)
    {
        return $items->map(function ($item) {
            $price = Price::query()
                ->where(function ($q) use ($item) {
                    $q->where('item_name', 'like', '%' . Str::limit((string) $item->item_identified, 30, '') . '%')
                      ->orWhere('category', $item->category);
                })
                ->orderByDesc('collected_at')
                ->first();

            $unitPrice = $price ? (float) $price->unit_price : 0.0;
            $qty = $this->numericQuantity($item->identified_quantity);
            $total = $unitPrice * $qty;

            return (object) [
                'item' => $item->item_identified,
                'category' => $item->category,
                'unit' => $item->suggested_unit,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'total' => $total,
                'has_price' => (bool) $price,
            ];
        });
    }

    protected function numericQuantity(?string $raw): float
    {
        if ($raw === null) {
            return 0.0;
        }
        $normalized = str_replace(['.', ' '], ['', ''], $raw);
        $normalized = str_replace(',', '.', $normalized);
        preg_match('/[0-9]+(\.[0-9]+)?/', $normalized, $m);

        return isset($m[0]) ? (float) $m[0] : 0.0;
    }
}
