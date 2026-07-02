@extends('layouts.app')
@section('title', 'Cotação')
@section('content')
@php $isEdit = $quoteRequest->exists; @endphp
<h1 class="h3 mb-4">{{ $isEdit ? 'Editar cotação' : 'Nova solicitação de cotação' }}</h1>

<div class="card"><div class="card-body">
    <form method="POST" action="{{ $isEdit ? route('quote-requests.update', $quoteRequest) : route('quote-requests.store') }}">
        @csrf
        @if($isEdit) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Obra</label>
                <select name="work_id" class="form-select">
                    <option value="">—</option>
                    @foreach ($works as $w)
                        <option value="{{ $w->id }}" @selected(old('work_id', $quoteRequest->work_id) == $w->id)>{{ $w->name }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Fornecedor</label>
                <select name="supplier_id" class="form-select">
                    <option value="">—</option>
                    @foreach ($suppliers as $s)
                        <option value="{{ $s->id }}" @selected(old('supplier_id', $quoteRequest->supplier_id) == $s->id)>{{ $s->name }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-4"><label class="form-label">Item extraído</label>
                <select name="extracted_item_id" class="form-select">
                    <option value="">—</option>
                    @foreach ($items as $it)
                        <option value="{{ $it->id }}" @selected(old('extracted_item_id', $quoteRequest->extracted_item_id) == $it->id)>{{ $it->item_identified }}</option>
                    @endforeach
                </select></div>

            <div class="col-md-8"><label class="form-label">Assunto</label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject', $quoteRequest->subject) }}"></div>
            <div class="col-md-4"><label class="form-label">Status</label>
                <input type="text" name="status" class="form-control" value="{{ old('status', $quoteRequest->status ?? 'draft') }}"></div>

            <div class="col-12"><label class="form-label">Corpo do e-mail (gerado automaticamente para itens sob medida)</label>
                <textarea name="body" rows="16" class="form-control" style="font-family:monospace; font-size:.85rem">{{ old('body', $quoteRequest->body) }}</textarea></div>

            <div class="col-md-4"><label class="form-label">Enviado em</label>
                <input type="datetime-local" name="sent_at" class="form-control" value="{{ old('sent_at', optional($quoteRequest->sent_at)->format('Y-m-d\TH:i')) }}"></div>
            <div class="col-md-4"><label class="form-label">Resposta recebida em</label>
                <input type="datetime-local" name="response_received_at" class="form-control" value="{{ old('response_received_at', optional($quoteRequest->response_received_at)->format('Y-m-d\TH:i')) }}"></div>
            <div class="col-12"><label class="form-label">Observações</label>
                <textarea name="notes" rows="2" class="form-control">{{ old('notes', $quoteRequest->notes) }}</textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">{{ $isEdit ? 'Atualizar' : 'Salvar' }}</button>
            <a href="{{ route('quote-requests.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
