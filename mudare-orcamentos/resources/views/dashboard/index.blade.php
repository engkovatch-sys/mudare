@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Dashboard</h1>
    <a href="{{ route('works.create') }}" class="btn btn-brand">+ Nova obra</a>
</div>

<div class="row g-3 mb-4">
    @php
        $cards = [
            ['Obras', $stats['works'], 'works.index'],
            ['Clientes', $stats['clients'], 'clients.index'],
            ['Arquitetos', $stats['architects'], 'architects.index'],
            ['Fornecedores', $stats['suppliers'], 'suppliers.index'],
        ];
    @endphp
    @foreach ($cards as [$label, $value, $route])
    <div class="col-6 col-md-3">
        <a href="{{ route($route) }}" class="text-decoration-none text-reset">
            <div class="card h-100"><div class="card-body">
                <div class="text-muted small">{{ $label }}</div>
                <div class="h2 mb-0 text-brand">{{ $value }}</div>
            </div></div>
        </a>
    </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card h-100"><div class="card-body">
            <div class="text-muted small">Itens extraídos</div>
            <div class="h3 mb-0">{{ $stats['items'] }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100 border-start border-4 border-secondary"><div class="card-body">
            <div class="text-muted small">Itens pendentes</div>
            <div class="h3 mb-0">{{ $stats['items_pending'] }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100 border-start border-4 border-warning"><div class="card-body">
            <div class="text-muted small">Alertas abertos</div>
            <div class="h3 mb-0">{{ $stats['alerts_open'] }}</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100 border-start border-4 border-danger"><div class="card-body">
            <div class="text-muted small">Alertas críticos</div>
            <div class="h3 mb-0 text-danger">{{ $stats['alerts_critical'] }}</div>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><strong>Obras recentes</strong></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Obra</th><th>Cliente</th><th>Arquiteto</th><th>Padrão</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($recentWorks as $work)
                <tr>
                    <td>{{ $work->name }}</td>
                    <td>{{ optional($work->client)->name ?? '—' }}</td>
                    <td>{{ optional($work->architect)->name ?? '—' }}</td>
                    <td>{{ $work->finish_standard }}</td>
                    <td><span class="badge bg-secondary">{{ $work->status }}</span></td>
                    <td class="text-end"><a href="{{ route('works.show', $work) }}" class="btn btn-sm btn-outline-brand">Abrir</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhuma obra cadastrada ainda.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
