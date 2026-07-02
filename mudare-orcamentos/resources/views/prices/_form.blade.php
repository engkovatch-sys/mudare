@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">Item *</label>
        <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $price->item_name) }}" required></div>
    <div class="col-md-6"><label class="form-label">Fornecedor</label>
        <select name="supplier_id" class="form-select">
            <option value="">—</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $price->supplier_id) == $supplier->id)>{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4"><label class="form-label">Categoria</label>
        <input type="text" name="category" class="form-control" value="{{ old('category', $price->category) }}"></div>
    <div class="col-md-4"><label class="form-label">Unidade *</label>
        <input type="text" name="unit" class="form-control" value="{{ old('unit', $price->unit) }}" placeholder="m², m, un, vb"></div>
    <div class="col-md-4"><label class="form-label">Preço unitário (R$) *</label>
        <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price', $price->unit_price) }}" required></div>

    <div class="col-md-4"><label class="form-label">Tipo de preço *</label>
        <select name="price_type" class="form-select" required>
            @foreach ($priceTypes as $pt)
                <option value="{{ $pt->value }}" @selected(old('price_type', $price->price_type) == $pt->value)>{{ $pt->label() }}</option>
            @endforeach
        </select>
        <div class="form-text">Estimado exige validação humana para ser final.</div>
    </div>
    <div class="col-md-4"><label class="form-label">Fonte</label>
        <input type="text" name="source" class="form-control" value="{{ old('source', $price->source) }}" placeholder="Tabela, cotação, site..."></div>
    <div class="col-md-4"><label class="form-label">URL da fonte</label>
        <input type="text" name="source_url" class="form-control" value="{{ old('source_url', $price->source_url) }}"></div>

    <div class="col-md-3"><label class="form-label">Coletado em</label>
        <input type="date" name="collected_at" class="form-control" value="{{ old('collected_at', optional($price->collected_at)->format('Y-m-d')) }}"></div>
    <div class="col-md-3"><label class="form-label">Validade</label>
        <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until', optional($price->valid_until)->format('Y-m-d')) }}"></div>
    <div class="col-md-3 d-flex align-items-end"><div class="form-check">
        <input type="checkbox" name="taxes_included" value="1" id="taxes" class="form-check-input" @checked(old('taxes_included', $price->taxes_included))>
        <label for="taxes" class="form-check-label">Impostos inclusos</label></div></div>
    <div class="col-md-3 d-flex align-items-end"><div class="form-check">
        <input type="checkbox" name="freight_included" value="1" id="freight" class="form-check-input" @checked(old('freight_included', $price->freight_included))>
        <label for="freight" class="form-check-label">Frete incluso</label></div></div>

    <div class="col-md-6"><label class="form-label">Responsável pela validação</label>
        <input type="text" name="validation_responsible" class="form-control" value="{{ old('validation_responsible', $price->validation_responsible) }}"></div>
    <div class="col-md-6"><label class="form-label">Status de validação</label>
        <select name="validation_status" class="form-select">
            @foreach ($validationStatuses as $vs)
                <option value="{{ $vs->value }}" @selected(old('validation_status', $price->validation_status) == $vs->value)>{{ $vs->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12"><label class="form-label">Observações</label>
        <textarea name="notes" rows="2" class="form-control">{{ old('notes', $price->notes) }}</textarea></div>
</div>
