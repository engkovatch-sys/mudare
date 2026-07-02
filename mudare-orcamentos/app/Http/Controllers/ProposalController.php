<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateProposalRequest;
use App\Models\Proposal;
use App\Models\Work;
use App\Services\InternalPdfService;
use App\Services\ProposalPdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProposalController extends Controller
{
    public function __construct(
        protected ProposalPdfService $commercialPdf,
        protected InternalPdfService $internalPdf,
    ) {
    }

    public function index(Work $work)
    {
        $proposals = $work->proposals()->latest('generated_at')->get();

        return view('proposals.index', compact('work', 'proposals'));
    }

    /**
     * Gera a proposta COMERCIAL. Bloqueia se houver item crítico pendente,
     * a não ser que o usuário confirme explicitamente.
     */
    public function commercial(GenerateProposalRequest $request, Work $work): RedirectResponse
    {
        $critical = $this->commercialPdf->criticalPendingItems($work);

        if ($critical->isNotEmpty() && ! $request->boolean('confirm_critical')) {
            return redirect()
                ->route('works.proposals.index', $work)
                ->with('error', 'Existem ' . $critical->count() . ' item(ns) crítico(s)/sob cotação ainda NÃO aprovado(s). '
                    . 'Revise-os ou confirme explicitamente a geração mesmo assim.')
                ->with('require_confirm_critical', true);
        }

        $proposal = $this->commercialPdf->generate($work);

        return redirect()
            ->route('works.proposals.index', $work)
            ->with('success', 'Proposta comercial gerada.')
            ->with('generated_proposal_id', $proposal->id);
    }

    public function internal(Work $work): RedirectResponse
    {
        $proposal = $this->internalPdf->generate($work);

        return redirect()
            ->route('works.proposals.index', $work)
            ->with('success', 'Relatório técnico interno gerado.')
            ->with('generated_proposal_id', $proposal->id);
    }

    public function show(Proposal $proposal)
    {
        $proposal->load('work');

        return view('proposals.show', compact('proposal'));
    }

    public function download(Proposal $proposal): BinaryFileResponse|RedirectResponse
    {
        if (! $proposal->file_path || ! Storage::disk('local')->exists($proposal->file_path)) {
            return back()->with('error', 'Arquivo da proposta não encontrado.');
        }

        $absolute = Storage::disk('local')->path($proposal->file_path);
        $downloadName = ($proposal->proposal_type === 'commercial' ? 'proposta_comercial_' : 'relatorio_interno_')
            . 'obra_' . $proposal->work_id . '.pdf';

        // Download por controller (não depende de storage:link).
        return response()->download($absolute, $downloadName);
    }
}
