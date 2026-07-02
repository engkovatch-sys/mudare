@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">Nome *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $architect->name) }}" required></div>
    <div class="col-md-6"><label class="form-label">Escritório</label>
        <input type="text" name="office_name" class="form-control" value="{{ old('office_name', $architect->office_name) }}"></div>
    <div class="col-md-6"><label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $architect->email) }}"></div>
    <div class="col-md-6"><label class="form-label">Telefone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $architect->phone) }}"></div>
    <div class="col-md-6"><label class="form-label">Website</label>
        <input type="text" name="website" class="form-control" value="{{ old('website', $architect->website) }}"></div>
    <div class="col-md-6"><label class="form-label">Instagram</label>
        <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $architect->instagram) }}"></div>
    <div class="col-12"><label class="form-label">Observações</label>
        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $architect->notes) }}</textarea></div>
</div>
