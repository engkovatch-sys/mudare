@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nome da obra *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $work->name) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Cliente</label>
        <select name="client_id" class="form-select">
            <option value="">—</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" @selected(old('client_id', $work->client_id) == $client->id)>{{ $client->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Arquiteto</label>
        <select name="architect_id" class="form-select">
            <option value="">—</option>
            @foreach ($architects as $architect)
                <option value="{{ $architect->id }}" @selected(old('architect_id', $work->architect_id) == $architect->id)>{{ $architect->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Endereço</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $work->address) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Cidade</label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $work->city) }}">
    </div>
    <div class="col-md-2">
        <label class="form-label">UF</label>
        <input type="text" name="state" maxlength="2" class="form-control" value="{{ old('state', $work->state) }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Área construída (m²)</label>
        <input type="number" step="0.01" name="built_area" class="form-control" value="{{ old('built_area', $work->built_area) }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Padrão de acabamento *</label>
        <select name="finish_standard" class="form-select" required>
            @foreach ($finishStandards as $fs)
                <option value="{{ $fs->value }}" @selected(old('finish_standard', $work->finish_standard) == $fs->value)>{{ $fs->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Data-base do orçamento</label>
        <input type="date" name="budget_base_date" class="form-control" value="{{ old('budget_base_date', optional($work->budget_base_date)->format('Y-m-d')) }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Status</label>
        <input type="text" name="status" class="form-control" value="{{ old('status', $work->status ?? 'rascunho') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Versão da proposta</label>
        <input type="text" name="proposal_version" class="form-control" value="{{ old('proposal_version', $work->proposal_version) }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Proposta válida até</label>
        <input type="date" name="proposal_valid_until" class="form-control" value="{{ old('proposal_valid_until', optional($work->proposal_valid_until)->format('Y-m-d')) }}">
    </div>

    <div class="col-12">
        <label class="form-label">Observações</label>
        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $work->notes) }}</textarea>
    </div>
</div>
