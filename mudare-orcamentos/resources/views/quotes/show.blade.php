@extends('layouts.app')
@section('title', 'Cotação')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Solicitação de cotação</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('quote-requests.edit', $quoteRequest) }}" class="btn btn-outline-secondary">Editar</a>
        <a href="{{ route('quote-requests.index') }}" class="btn btn-outline-secondary">Voltar</a>
    </div>
</div>

<div class="card mb-3"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">Assunto</dt><dd class="col-sm-9">{{ $quoteRequest->subject ?? '—' }}</dd>
        <dt class="col-sm-3">Obra</dt><dd class="col-sm-9">{{ optional($quoteRequest->work)->name ?? '—' }}</dd>
        <dt class="col-sm-3">Fornecedor</dt><dd class="col-sm-9">{{ optional($quoteRequest->supplier)->name ?? '—' }}</dd>
        <dt class="col-sm-3">Item</dt><dd class="col-sm-9">{{ optional($quoteRequest->extractedItem)->item_identified ?? '—' }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9"><span class="badge bg-secondary">{{ $quoteRequest->status }}</span></dd>
    </dl>
</div></div>

<div class="card"><div class="card-header bg-white"><strong>Corpo do e-mail</strong></div>
    <div class="card-body"><pre class="mb-0" style="white-space:pre-wrap; font-size:.9rem">{{ $quoteRequest->body ?? '—' }}</pre></div>
</div>
@endsection
