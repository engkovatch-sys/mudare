@extends('layouts.app')
@section('title', 'Itens extraídos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h3 mb-0">Itens extraídos</h1>
    <a href="{{ route('works.show', $work) }}" class="btn btn-outline-secondary">Voltar à obra</a>
</div>
<p class="text-muted">Obra: <strong>{{ $work->name }}</strong> — revisão humana obrigatória. Somente itens <span class="badge bg-success">approved</span> entram sem alerta crítico no PDF comercial.</p>

<div class="card"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Item</th><th>Categoria</th><th>Ambiente</th><th>Unid.</th><th>Qtd.</th><th>Criticidade</th><th>Cotação</th><th>Conf.</th><th>Validação</th><th></th></tr></thead>
        <tbody>
        @forelse ($items as $item)
            <tr>
                <td class="fw-semibold">{{ $item->item_identified }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->environment }}</td>
                <td>{{ $item->suggested_unit }}</td>
                <td>{{ $item->identified_quantity }}</td>
                <td>{{ $item->criticality }}</td>
                <td>{!! $item->requires_specific_quote ? '<span class="badge bg-warning text-dark">sim</span>' : '—' !!}</td>
                <td>{{ $item->confidence_score }}%</td>
                <td>
                    @php $vs = \App\Enums\ValidationStatus::tryFrom($item->validation_status); @endphp
                    <span class="badge {{ $vs?->badgeClass() ?? 'bg-secondary' }}">{{ $item->validation_status }}</span>
                </td>
                <td class="text-end">
                    <a href="{{ route('extracted-items.edit', $item) }}" class="btn btn-sm btn-outline-brand">Revisar</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="10" class="text-center text-muted py-4">
                Nenhum item extraído. Processe um memorial com a IA primeiro.
            </td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
