@extends('layouts.app')
@section('title', 'Cotações')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Solicitações de cotação</h1>
    <a href="{{ route('quote-requests.create') }}" class="btn btn-brand">+ Nova cotação</a>
</div>
<div class="card"><div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Assunto</th><th>Obra</th><th>Fornecedor</th><th>Item</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($quoteRequests as $qr)
            <tr>
                <td class="fw-semibold">{{ $qr->subject ?? '—' }}</td>
                <td>{{ optional($qr->work)->name ?? '—' }}</td>
                <td>{{ optional($qr->supplier)->name ?? '—' }}</td>
                <td>{{ optional($qr->extractedItem)->item_identified ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $qr->status }}</span></td>
                <td class="text-end"><a href="{{ route('quote-requests.show', $qr) }}" class="btn btn-sm btn-outline-brand">Abrir</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Nenhuma cotação registrada.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $quoteRequests->links() }}</div>
@endsection
