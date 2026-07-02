@extends('layouts.app')
@section('title', 'Editar preço')
@section('content')
<h1 class="h3 mb-4">Editar preço</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('prices.update', $price) }}">
        @method('PUT')
        @include('prices._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Atualizar</button>
            <a href="{{ route('prices.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
