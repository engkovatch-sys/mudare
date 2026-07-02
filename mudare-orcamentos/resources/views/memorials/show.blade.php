@extends('layouts.app')
@section('title', 'Memorial')
@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3 mb-1">Memorial</h1>
        <p class="text-muted mb-0">Obra: <a href="{{ route('works.show', $memorial->work) }}" class="text-brand text-decoration-none">{{ $memorial->work->name }}</a></p>
    </div>
    <span class="badge {{ $memorial->processing_status === 'processed' ? 'bg-success' : ($memorial->processing_status === 'failed' ? 'bg-danger' : 'bg-secondary') }} fs-6">
        {{ $memorial->processing_status }}
    </span>
</div>

@if($memorial->error_message)
    <div class="alert alert-warning small"><strong>Aviso:</strong> {{ $memorial->error_message }}</div>
@endif

<div class="row g-3 mb-3">
    <div class="col-md-4"><div class="card"><div class="card-body">
        <div class="text-muted small">Modo de extração</div><div class="fw-semibold">{{ $memorial->extraction_mode }}</div>
    </div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
        <div class="text-muted small">Arquivo</div><div class="fw-semibold">{{ $memorial->original_filename ?? '— (texto manual)' }}</div>
    </div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
        <div class="text-muted small">Processado em</div><div class="fw-semibold">{{ optional($memorial->processed_at)->format('d/m/Y H:i') ?? '—' }}</div>
    </div></div></div>
</div>

<div class="card mb-3">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Processar com IA (Anthropic)</strong>
        @unless($anthropicConfigured)
            <span class="badge bg-danger">API não configurada</span>
        @endunless
    </div>
    <div class="card-body">
        @unless($anthropicConfigured)
            <p class="text-muted small mb-3">API Anthropic não configurada. Verifique o arquivo <code>.env</code> (ANTHROPIC_API_KEY).
            O botão abaixo retornará uma mensagem amigável.</p>
        @endunless
        <form method="POST" action="{{ route('memorials.process', $memorial) }}">
            @csrf
            <button class="btn btn-brand" @disabled($memorial->processing_status === 'processing')>
                Extrair itens com IA
            </button>
        </form>
        <p class="small text-muted mt-2 mb-0">Todos os itens extraídos nascem como <strong>pending</strong> e exigem revisão humana.</p>
    </div>
</div>

@if($memorial->extractedItems->count())
<div class="card mb-3">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Itens extraídos deste memorial ({{ $memorial->extractedItems->count() }})</strong>
        <a href="{{ route('works.extracted-items.index', $memorial->work_id) }}" class="btn btn-sm btn-outline-brand">Revisar itens</a>
    </div>
    <ul class="list-group list-group-flush">
        @foreach($memorial->extractedItems->take(10) as $item)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $item->item_identified }} <small class="text-muted">({{ $item->category }})</small></span>
                <span class="badge bg-secondary">{{ $item->validation_status }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100"><div class="card-header bg-white"><strong>Texto extraído (PDF)</strong></div>
            <div class="card-body"><pre class="small mb-0" style="white-space:pre-wrap; max-height:400px; overflow:auto">{{ $memorial->extracted_text ?? '— (não extraído / fallback manual)' }}</pre></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100"><div class="card-header bg-white"><strong>Texto manual (fallback)</strong></div>
            <div class="card-body"><pre class="small mb-0" style="white-space:pre-wrap; max-height:400px; overflow:auto">{{ $memorial->manual_text ?? '—' }}</pre></div>
        </div>
    </div>
</div>
@endsection
