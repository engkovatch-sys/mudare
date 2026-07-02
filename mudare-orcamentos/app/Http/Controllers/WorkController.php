<?php

namespace App\Http\Controllers;

use App\Enums\FinishStandard;
use App\Http\Requests\StoreWorkRequest;
use App\Http\Requests\UpdateWorkRequest;
use App\Models\Architect;
use App\Models\Client;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function index(): View
    {
        $works = Work::with(['client', 'architect'])->latest()->paginate(15);

        return view('works.index', compact('works'));
    }

    public function create(): View
    {
        return view('works.create', [
            'work' => new Work(['finish_standard' => 'nao_identificado', 'status' => 'rascunho']),
            'clients' => Client::orderBy('name')->get(),
            'architects' => Architect::orderBy('name')->get(),
            'finishStandards' => FinishStandard::cases(),
        ]);
    }

    public function store(StoreWorkRequest $request): RedirectResponse
    {
        $work = Work::create($request->validated());

        return redirect()->route('works.show', $work)->with('success', 'Obra cadastrada com sucesso.');
    }

    public function show(Work $work): View
    {
        $work->load(['client', 'architect', 'memorials', 'proposals']);
        $work->loadCount([
            'extractedItems',
            'extractedItems as approved_items_count' => fn ($q) => $q->where('validation_status', 'approved'),
            'extractedItems as pending_items_count' => fn ($q) => $q->where('validation_status', 'pending'),
            'alerts as open_alerts_count' => fn ($q) => $q->whereNull('resolved_at'),
        ]);

        return view('works.show', compact('work'));
    }

    public function edit(Work $work): View
    {
        return view('works.edit', [
            'work' => $work,
            'clients' => Client::orderBy('name')->get(),
            'architects' => Architect::orderBy('name')->get(),
            'finishStandards' => FinishStandard::cases(),
        ]);
    }

    public function update(UpdateWorkRequest $request, Work $work): RedirectResponse
    {
        $work->update($request->validated());

        return redirect()->route('works.show', $work)->with('success', 'Obra atualizada com sucesso.');
    }

    public function destroy(Work $work): RedirectResponse
    {
        $work->delete();

        return redirect()->route('works.index')->with('success', 'Obra removida.');
    }
}
