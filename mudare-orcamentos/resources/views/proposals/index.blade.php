@extends('layouts.app')
@section('title', 'Propostas')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h3 mb-0">Propostas e PDFs</h1>
    <a href="{{ route('works.show', $work) }}" class="btn btn-outline-secondary">Voltar à obra</a>
</div>
<p class="text-muted">Obra: <strong>{{ $work->name }}</strong></p>

@if(session('require_confirm_critical'))
<div class="alert alert-danger">
    <strong>Itens críticos/sob cotação pendentes.</strong> Para gerar mesmo assim, confirme abaixo.
    <form method="POST" action="{{ route('works.proposals.commercial', $work) }}" class="mt-2">
        @csrf
        <input type="hidden" name="confirm_critical" value="1">
        <button class="btn btn-sm btn-danger">Gerar comercial mesmo assim</button>
    </form>
</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-6"><div class="card h-100"><div class="card-body">
        <h2 class="h5">PDF Comercial</h2>
        <p class="small text-muted">Voltado ao cliente. Não expõe fragilidades internas. Bloqueia se houver item crítico pendente.</p>
        <form method="POST" action="{{ route('works.proposals.commercial', $work) }}">
            @csrf
            <button class="btn btn-brand">Gerar PDF comercial</button>
        </form>
    </div></div></div>
    <div class="col-md-6"><div class="card h-100"><div class="card-body">
        <h2 class="h5">PDF Técnico Interno</h2>
        <p class="small text-muted">Uso da engenharia. Exibe itens sem evidência, sem preço, estimados, alertas e lacunas.</p>
        <form method="POST" action="{{ route('works.proposals.internal', $work) }}">
            @csrf
            <button class="btn btn-outline-brand">Gerar PDF interno</button>
        </form>
    </div></div></div>
</div>

<div class="card"><div class="card-header bg-white"><strong>Propostas geradas</strong></div>
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Título</th><th>Tipo</th><th>Valor total</th><th>Gerada em</th><th></th></tr></thead>
        <tbody>
        @forelse ($proposals as $proposal)
            <tr>
                <td>{{ $proposal->title }}</td>
                <td><span class="badge {{ $proposal->proposal_type === 'commercial' ? 'bg-brand' : 'bg-secondary' }}">{{ $proposal->proposal_type }}</span></td>
                <td>{{ $proposal->total_amount !== null ? 'R$ '.number_format((float)$proposal->total_amount,2,',','.') : '—' }}</td>
                <td>{{ optional($proposal->generated_at)->format('d/m/Y H:i') }}</td>
                <td class="text-end">
                    <a href="{{ route('proposals.show', $proposal) }}" class="btn btn-sm btn-outline-secondary">Detalhes</a>
                    <a href="{{ route('proposals.download', $proposal) }}" class="btn btn-sm btn-outline-brand">Baixar PDF</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhuma proposta gerada ainda.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
