<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Work;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Gera o PDF TÉCNICO INTERNO (uso da engenharia/orçamento).
 *
 * Expõe TODA a fragilidade: itens sem evidência, sem preço, estimados,
 * alertas da malha fina, lacunas de especificação e recomendações.
 */
class InternalPdfService
{
    public function generate(Work $work): Proposal
    {
        $work->loadMissing(['client', 'architect']);

        $items = $work->extractedItems()->orderBy('category')->get();

        $withoutEvidence = $items->filter(
            fn ($i) => blank($i->textual_evidence) || $i->textual_evidence === 'não identificado'
        );

        $withGaps = $items->filter(
            fn ($i) => filled($i->specification_gaps) && $i->specification_gaps !== 'não identificado'
        );

        $estimatedOrPending = $items->filter(
            fn ($i) => $i->validation_status !== 'approved'
        );

        $alerts = $work->alerts()->whereNull('resolved_at')->orderByRaw(
            "CASE severity WHEN 'critico' THEN 1 WHEN 'alto' THEN 2 WHEN 'medio' THEN 3 WHEN 'baixo' THEN 4 ELSE 5 END"
        )->get();

        $data = [
            'work' => $work,
            'items' => $items,
            'withoutEvidence' => $withoutEvidence,
            'withGaps' => $withGaps,
            'estimatedOrPending' => $estimatedOrPending,
            'alerts' => $alerts,
            'brandColor' => env('PDF_BRAND_COLOR', '#DD5600'),
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('pdfs.internal', $data)->setPaper('a4');

        $filename = 'proposals/interno_obra_' . $work->id . '_' . Str::random(8) . '.pdf';
        Storage::disk('local')->put($filename, $pdf->output());

        return Proposal::create([
            'work_id' => $work->id,
            'proposal_type' => 'internal',
            'title' => 'Relatório Técnico Interno - ' . $work->name,
            'file_path' => $filename,
            'total_amount' => null,
            'status' => 'generated',
            'generated_at' => now(),
        ]);
    }
}
