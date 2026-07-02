@extends('layouts.app')

@section('title', 'Nova obra')

@section('content')
<h1 class="h3 mb-4">Nova obra</h1>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('works.store') }}">
        @include('works._form')
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-brand">Salvar obra</button>
            <a href="{{ route('works.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection
