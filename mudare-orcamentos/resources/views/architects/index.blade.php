@extends('layouts.app')
@section('title', 'Arquitetos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Arquitetos</h1>
    <a href="{{ route('architects.create') }}" class="btn btn-brand">+ Novo arquiteto</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Nome</th><th>Escritório</th><th>E-mail</th><th>Instagram</th><th></th></tr></thead>
        <tbody>
        @forelse ($architects as $architect)
            <tr>
                <td class="fw-semibold">{{ $architect->name }}</td>
                <td>{{ $architect->office_name ?? '—' }}</td>
                <td>{{ $architect->email ?? '—' }}</td>
                <td>{{ $architect->instagram ?? '—' }}</td>
                <td class="text-end">
                    <a href="{{ route('architects.edit', $architect) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form method="POST" action="{{ route('architects.destroy', $architect) }}" class="d-inline" onsubmit="return confirm('Remover arquiteto?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhum arquiteto cadastrado.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $architects->links() }}</div>
@endsection
