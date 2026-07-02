@extends('layouts.app')
@section('title', 'Fornecedores')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Fornecedores</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-brand">+ Novo fornecedor</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Nome</th><th>Categoria</th><th>Contato</th><th>Cidade/UF</th><th></th></tr></thead>
        <tbody>
        @forelse ($suppliers as $supplier)
            <tr>
                <td class="fw-semibold">{{ $supplier->name }}</td>
                <td>{{ $supplier->category ?? '—' }}</td>
                <td>{{ $supplier->contact_name ?? '—' }}</td>
                <td>{{ $supplier->city ? $supplier->city.'/'.$supplier->state : '—' }}</td>
                <td class="text-end">
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="d-inline" onsubmit="return confirm('Remover fornecedor?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhum fornecedor cadastrado.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $suppliers->links() }}</div>
@endsection
