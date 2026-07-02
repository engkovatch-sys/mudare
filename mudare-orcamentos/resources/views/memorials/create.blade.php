@extends('layouts.app')
@section('title', 'Novo memorial')
@section('content')
<h1 class="h3 mb-1">Memorial descritivo</h1>
<p class="text-muted">Obra: <strong>{{ $work->name }}</strong></p>

<div class="alert alert-info small">
    <strong>Fallback obrigatório:</strong> se a extração automática do PDF falhar (PDF digitalizado, protegido, etc.),
    cole o texto do memorial manualmente. O campo de texto manual sempre funciona.
</div>

<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('memorials.store', $work) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Arquivo PDF do memorial (opcional, máx. 20 MB)</label>
            <input type="file" name="pdf" accept="application/pdf" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Texto do memorial (colar manualmente) — fallback funcional</label>
            <textarea name="manual_text" rows="12" class="form-control" placeholder="Cole aqui o conteúdo do memorial descritivo...">{{ old('manual_text') }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-brand">Salvar memorial</button>
            <a href="{{ route('works.show', $work) }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
