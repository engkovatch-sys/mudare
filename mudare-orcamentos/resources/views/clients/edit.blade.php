@extends('layouts.app')
@section('title', 'Editar cliente')
@section('content')
<h1 class="h3 mb-4">Editar cliente</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('clients.update', $client) }}">
        @method('PUT')
        @include('clients._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Atualizar</button>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
