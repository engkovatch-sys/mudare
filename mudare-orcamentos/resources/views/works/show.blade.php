@extends('layouts.app')

@section('title', $work->name)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-1">{{ $work->name }}</h1>
        <div class="text-muted">
            {{ optional($work->client)->name ?? 'Sem cliente' }}
            @if($work->architect) · Arq. {{ $work->architect->name }} @endif
            @if($work->city) · {{ $work->city }}/{{ $work->state }} @endif
        </div>
    </div>
    <a href="{{ route('works.edit', $work) }}" class="btn btn-outline-secondary">Editar</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card"><div class="card-body text-center">
        <div class="text-muted small">Itens</div><div class="h4 mb-0">{{ $work->extracted_items_count }}</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card"><div class="card-body text-center">
        <div class="text-muted small">Aprovados</div><div class="h4 mb-0 text-success">{{ $work->approved_items_count }}</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card"><div class="card-body text-center">
        <div class="text-muted small">Pendentes</div><div class="h4 mb-0 text-secondary">{{ $work->pending_items_count }}</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card"><div class="card-body text-center">
        <div class="text-muted small">Alertas abertos</div><div class="h4 mb-0 text-warning">{{ $work->open_alerts_count }}</div></div></div></div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Memoriais descritivos</strong>
                <a href="{{ route('memorials.create', $work) }}" class="btn btn-sm btn-brand">+ Memorial</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($work->memorials as $memorial)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            {{ $memorial->original_filename ?? 'Texto colado manualmente' }}
                            <span class="badge {{ $memorial->processing_status === 'processed' ? 'bg-success' : ($memorial->processing_status === 'failed' ? 'bg-danger' : 'bg-secondary') }}">{{ $memorial->processing_status }}</span>
                        </span>
                        <a href="{{ route('memorials.show', $memorial) }}" class="btn btn-sm btn-outline-brand">Abrir</a>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Nenhum memorial. Faça upload de PDF ou cole o texto.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white"><strong>Fluxo orçamentário</strong></div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('works.extracted-items.index', $work) }}" class="btn btn-outline-brand text-start">1. Itens extraídos (revisão humana)</a>
                <form method="POST" action="{{ route('works.fine-comb', $work) }}">
                    @csrf
                    <button class="btn btn-outline-brand w-100 text-start">2. Rodar malha fina orçamentária</button>
                </form>
                <a href="{{ route('works.alerts.index', $work) }}" class="btn btn-outline-brand text-start">3. Ver alertas técnicos</a>
                <a href="{{ route('works.proposals.index', $work) }}" class="btn btn-outline-brand text-start">4. Propostas / PDFs</a>

                <hr class="my-2">
                <div class="btn-group">
                    <a href="{{ route('works.export.csv', $work) }}?type=items" class="btn btn-sm btn-outline-secondary">CSV itens</a>
                    <a href="{{ route('works.export.csv', $work) }}?type=prices" class="btn btn-sm btn-outline-secondary">CSV preços</a>
                    <a href="{{ route('works.export.csv', $work) }}?type=alerts" class="btn btn-sm btn-outline-secondary">CSV alertas</a>
                    <a href="{{ route('works.export.csv', $work) }}?type=proposal" class="btn btn-sm btn-outline-secondary">CSV resumo</a>
                </div>

                <form method="POST" action="{{ route('works.webhook', $work) }}" class="mt-2">
                    @csrf
                    <div class="input-group input-group-sm">
                        <input type="url" name="target_url" class="form-control" placeholder="URL do webhook (opcional; usa WEBHOOK_DEFAULT_URL)">
                        <button class="btn btn-outline-brand">Disparar webhook</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-white"><strong>Dados da obra</strong></div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Área construída</dt><dd class="col-sm-3">{{ $work->built_area ? number_format($work->built_area,2,',','.').' m²' : 'não identificado' }}</dd>
            <dt class="col-sm-3">Padrão</dt><dd class="col-sm-3">{{ $work->finish_standard }}</dd>
            <dt class="col-sm-3">Data-base</dt><dd class="col-sm-3">{{ optional($work->budget_base_date)->format('d/m/Y') ?? 'não identificado' }}</dd>
            <dt class="col-sm-3">Versão da proposta</dt><dd class="col-sm-3">{{ $work->proposal_version ?? '—' }}</dd>
            <dt class="col-sm-3">Válida até</dt><dd class="col-sm-3">{{ optional($work->proposal_valid_until)->format('d/m/Y') ?? '—' }}</dd>
            <dt class="col-sm-3">Status</dt><dd class="col-sm-3">{{ $work->status }}</dd>
            @if($work->notes)<dt class="col-sm-3">Observações</dt><dd class="col-sm-9">{{ $work->notes }}</dd>@endif
        </dl>
    </div>
</div>
@endsection
