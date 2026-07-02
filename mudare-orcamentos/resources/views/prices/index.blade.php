@extends('layouts.app')
@section('title', 'Preços')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Preços <small class="text-muted fs-6">com rastreabilidade</small></h1>
    <a href="{{ route('prices.create') }}" class="btn btn-brand">+ Novo preço</a>
</div>
<div class="alert alert-light border small">
    <strong>Regra:</strong> nenhum preço é final sem fornecedor, fonte, data, unidade, validade e responsável.
    Preço <em>estimado</em> não pode ser tratado como final sem validação humana.
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Item</th><th>Fornecedor</th><th>Unid.</th><th>Preço</th><th>Tipo</th><th>Validação</th><th>Rastreável</th><th></th></tr></thead>
        <tbody>
        @forelse ($prices as $price)
            @php $issues = $traceability->issues($price); @endphp
            <tr>
                <td class="fw-semibold">{{ $price->item_name }}</td>
                <td>{{ optional($price->supplier)->name ?? '—' }}</td>
                <td>{{ $price->unit ?? '—' }}</td>
                <td>R$ {{ number_format((float)$price->unit_price, 2, ',', '.') }}</td>
                <td><span class="badge bg-light text-dark border">{{ $price->price_type }}</span></td>
                <td><span class="badge {{ $price->validation_status === 'approved' ? 'bg-success' : 'bg-secondary' }}">{{ $price->validation_status }}</span></td>
                <td>
                    @if(empty($issues))
                        <span class="badge bg-success">OK</span>
                    @else
                        <span class="badge bg-warning text-dark" title="{{ implode(' ', $issues) }}">{{ count($issues) }} pendência(s)</span>
                    @endif
                </td>
                <td class="text-end">
                    <a href="{{ route('prices.edit', $price) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form method="POST" action="{{ route('prices.destroy', $price) }}" class="d-inline" onsubmit="return confirm('Remover preço?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted py-4">Nenhum preço cadastrado.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $prices->links() }}</div>
@endsection
