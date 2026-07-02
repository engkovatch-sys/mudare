@extends('layouts.app')
@section('title', 'Editar arquiteto')
@section('content')
<h1 class="h3 mb-4">Editar arquiteto</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('architects.update', $architect) }}">
        @method('PUT')
        @include('architects._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Atualizar</button>
            <a href="{{ route('architects.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
