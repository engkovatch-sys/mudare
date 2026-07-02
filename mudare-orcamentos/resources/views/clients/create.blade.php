@extends('layouts.app')
@section('title', 'Novo cliente')
@section('content')
<h1 class="h3 mb-4">Novo cliente</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('clients.store') }}">
        @include('clients._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Salvar</button>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
