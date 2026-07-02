@extends('layouts.app')
@section('title', 'Novo fornecedor')
@section('content')
<h1 class="h3 mb-4">Novo fornecedor</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('suppliers.store') }}">
        @include('suppliers._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Salvar</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
