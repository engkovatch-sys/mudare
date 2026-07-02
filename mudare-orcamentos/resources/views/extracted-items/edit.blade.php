@extends('layouts.app')
@section('title', 'Revisar item')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Revisar item extraído</h1>
    <a href="{{ route('works.extracted-items.index', $item->work_id) }}" class="btn btn-outline-secondary">Voltar</a>
</div>

@if($item->textual_evidence && $item->textual_evidence !== 'não identificado')
<div class="alert alert-light border">
    <div class="small text-muted mb-1">Evidência textual (memorial):</div>
    <em>{{ $item->textual_evidence }}</em>
</div>
@else
<div class="alert alert-warning small">Este item NÃO possui evidência textual. Verifique a origem antes de aprovar.</div>
@endif

<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('extracted-items.update', $item) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Item identificado *</label>
                <input type="text" name="item_identified" class="form-control" value="{{ old('item_identified', $item->item_identified) }}" required></div>
            <div class="col-md-3"><label class="form-label">Categoria</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $item->category) }}"></div>
            <div class="col-md-3"><label class="form-label">Subcategoria</label>
                <input type="text" name="subcategory" class="form-control" value="{{ old('subcategory', $item->subcategory) }}"></div>

            <div class="col-md-4"><label class="form-label">Ambiente</label>
                <input type="text" name="environment" class="form-control" value="{{ old('environment', $item->environment) }}"></div>
            <div class="col-md-4"><label class="form-label">Unidade sugerida</label>
                <input type="text" name="suggested_unit" class="form-control" value="{{ old('suggested_unit', $item->suggested_unit) }}"></div>
            <div class="col-md-4"><label class="form-label">Quantidade identificada</label>
                <input type="text" name="identified_quantity" class="form-control" value="{{ old('identified_quantity', $item->identified_quantity) }}"></div>

            <div class="col-12"><label class="form-label">Descrição técnica</label>
                <textarea name="technical_description" rows="3" class="form-control">{{ old('technical_description', $item->technical_description) }}</textarea></div>

            <div class="col-md-3"><label class="form-label">Impacto orçamentário *</label>
                <select name="budget_impact" class="form-select">
                    @foreach ($budgetImpacts as $bi)
                        <option value="{{ $bi->value }}" @selected(old('budget_impact', $item->budget_impact) == $bi->value)>{{ $bi->label() }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-3"><label class="form-label">Criticidade *</label>
                <select name="criticality" class="form-select">
                    @foreach ($criticalities as $c)
                        <option value="{{ $c->value }}" @selected(old('criticality', $item->criticality) == $c->value)>{{ $c->label() }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-3"><label class="form-label">Padrão de acabamento *</label>
                <select name="finish_standard" class="form-select">
                    @foreach ($finishStandards as $fs)
                        <option value="{{ $fs->value }}" @selected(old('finish_standard', $item->finish_standard) == $fs->value)>{{ $fs->label() }}</option>
                    @endforeach
                </select></div>
            <div class="col-md-3"><label class="form-label">Confiança (0-100)</label>
                <input type="number" min="0" max="100" name="confidence_score" class="form-control" value="{{ old('confidence_score', $item->confidence_score) }}"></div>

            <div class="col-md-3 d-flex align-items-end"><div class="form-check">
                <input type="checkbox" name="requires_specific_quote" value="1" id="rsq" class="form-check-input" @checked(old('requires_specific_quote', $item->requires_specific_quote))>
                <label for="rsq" class="form-check-label">Exige cotação formal</label></div></div>
            <div class="col-md-3"><label class="form-label">Página de origem</label>
                <input type="text" name="source_page" class="form-control" value="{{ old('source_page', $item->source_page) }}"></div>

            <div class="col-12"><label class="form-label">Evidência textual</label>
                <textarea name="textual_evidence" rows="2" class="form-control">{{ old('textual_evidence', $item->textual_evidence) }}</textarea></div>
            <div class="col-12"><label class="form-label">Lacunas de especificação</label>
                <textarea name="specification_gaps" rows="2" class="form-control">{{ old('specification_gaps', $item->specification_gaps) }}</textarea></div>
            <div class="col-12"><label class="form-label">Nota de validação humana</label>
                <textarea name="human_validation_note" rows="2" class="form-control">{{ old('human_validation_note', $item->human_validation_note) }}</textarea></div>

            <div class="col-md-6"><label class="form-label">Status de validação *</label>
                <select name="validation_status" class="form-select">
                    @foreach ($validationStatuses as $vs)
                        <option value="{{ $vs->value }}" @selected(old('validation_status', $item->validation_status) == $vs->value)>{{ $vs->label() }}</option>
                    @endforeach
                </select>
                <div class="form-text">Aprovar = liberar para PDF comercial sem alerta crítico.</div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Salvar revisão</button>
            <a href="{{ route('works.extracted-items.index', $item->work_id) }}" class="btn btn-outline-secondary">Cancelar</a>
            @if($item->requires_specific_quote)
                <a href="{{ route('quote-requests.create', ['extracted_item_id' => $item->id]) }}" class="btn btn-outline-brand ms-auto">Gerar cotação</a>
            @endif
        </div>
    </form>
</div></div>
@endsection
