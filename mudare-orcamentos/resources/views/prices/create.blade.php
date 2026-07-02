@extends('layouts.app')
@section('title', 'Novo preço')
@section('content')
<h1 class="h3 mb-4">Novo preço</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('prices.store') }}">
        @include('prices._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Salvar</button>
            <a href="{{ route('prices.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
