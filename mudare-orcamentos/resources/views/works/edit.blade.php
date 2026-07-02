@extends('layouts.app')

@section('title', 'Editar obra')

@section('content')
<h1 class="h3 mb-4">Editar obra</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('works.update', $work) }}">
        @method('PUT')
        @include('works._form')
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-brand">Atualizar</button>
            <a href="{{ route('works.show', $work) }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
    <hr>
    <form method="POST" action="{{ route('works.destroy', $work) }}" onsubmit="return confirm('Remover esta obra e todos os dados associados?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-outline-danger">Excluir obra</button>
    </form>
</div></div>
@endsection
