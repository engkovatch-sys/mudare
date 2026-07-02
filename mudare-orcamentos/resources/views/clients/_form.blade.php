@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">Nome *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required></div>
    <div class="col-md-6"><label class="form-label">Documento (CPF/CNPJ)</label>
        <input type="text" name="document" class="form-control" value="{{ old('document', $client->document) }}"></div>
    <div class="col-md-6"><label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}"></div>
    <div class="col-md-6"><label class="form-label">Telefone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}"></div>
    <div class="col-12"><label class="form-label">Endereço</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $client->address) }}"></div>
    <div class="col-12"><label class="form-label">Observações</label>
        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $client->notes) }}</textarea></div>
</div>
