@extends('layouts.app')
@section('title', 'Editar fornecedor')
@section('content')
<h1 class="h3 mb-4">Editar fornecedor</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
        @method('PUT')
        @include('suppliers._form')
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Atualizar</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
