@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">Nome *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required></div>
    <div class="col-md-6"><label class="form-label">Categoria</label>
        <input type="text" name="category" class="form-control" value="{{ old('category', $supplier->category) }}"
               placeholder="Ex: Esquadrias, Mármores, Automação"></div>
    <div class="col-md-6"><label class="form-label">Contato</label>
        <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', $supplier->contact_name) }}"></div>
    <div class="col-md-6"><label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}"></div>
    <div class="col-md-4"><label class="form-label">Telefone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}"></div>
    <div class="col-md-4"><label class="form-label">Cidade</label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $supplier->city) }}"></div>
    <div class="col-md-2"><label class="form-label">UF</label>
        <input type="text" name="state" maxlength="2" class="form-control" value="{{ old('state', $supplier->state) }}"></div>
    <div class="col-md-2"><label class="form-label">Website</label>
        <input type="text" name="website" class="form-control" value="{{ old('website', $supplier->website) }}"></div>
    <div class="col-12"><label class="form-label">Observações</label>
        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $supplier->notes) }}</textarea></div>
</div>
