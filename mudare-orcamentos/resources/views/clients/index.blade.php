@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Clientes</h1>
    <a href="{{ route('clients.create') }}" class="btn btn-brand">+ Novo cliente</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Nome</th><th>Documento</th><th>E-mail</th><th>Telefone</th><th></th></tr></thead>
        <tbody>
        @forelse ($clients as $client)
            <tr>
                <td class="fw-semibold">{{ $client->name }}</td>
                <td>{{ $client->document ?? '—' }}</td>
                <td>{{ $client->email ?? '—' }}</td>
                <td>{{ $client->phone ?? '—' }}</td>
                <td class="text-end">
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form method="POST" action="{{ route('clients.destroy', $client) }}" class="d-inline" onsubmit="return confirm('Remover cliente?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhum cliente cadastrado.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $clients->links() }}</div>
@endsection
