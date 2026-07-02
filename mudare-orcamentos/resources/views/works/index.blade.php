@extends('layouts.app')

@section('title', 'Obras')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Obras</h1>
    <a href="{{ route('works.create') }}" class="btn btn-brand">+ Nova obra</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Obra</th><th>Cliente</th><th>Cidade/UF</th><th>Área (m²)</th><th>Padrão</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($works as $work)
                <tr>
                    <td><a href="{{ route('works.show', $work) }}" class="text-brand fw-semibold text-decoration-none">{{ $work->name }}</a></td>
                    <td>{{ optional($work->client)->name ?? '—' }}</td>
                    <td>{{ $work->city ? $work->city.'/'.$work->state : '—' }}</td>
                    <td>{{ $work->built_area ? number_format($work->built_area, 2, ',', '.') : '—' }}</td>
                    <td>{{ $work->finish_standard }}</td>
                    <td><span class="badge bg-secondary">{{ $work->status }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('works.show', $work) }}" class="btn btn-sm btn-outline-brand">Abrir</a>
                        <a href="{{ route('works.edit', $work) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nenhuma obra cadastrada.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $works->links() }}</div>
@endsection
