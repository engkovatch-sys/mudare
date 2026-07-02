@extends('layouts.app')
@section('title', 'Proposta')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">{{ $proposal->title }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('proposals.download', $proposal) }}" class="btn btn-brand">Baixar PDF</a>
        <a href="{{ route('works.proposals.index', $proposal->work_id) }}" class="btn btn-outline-secondary">Voltar</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">Obra</dt><dd class="col-sm-9">{{ optional($proposal->work)->name }}</dd>
        <dt class="col-sm-3">Tipo</dt><dd class="col-sm-9">{{ $proposal->proposal_type }}</dd>
        <dt class="col-sm-3">Valor total</dt><dd class="col-sm-9">{{ $proposal->total_amount !== null ? 'R$ '.number_format((float)$proposal->total_amount,2,',','.') : '—' }}</dd>
        <dt class="col-sm-3">Gerada em</dt><dd class="col-sm-9">{{ optional($proposal->generated_at)->format('d/m/Y H:i') }}</dd>
        <dt class="col-sm-3">Válida até</dt><dd class="col-sm-9">{{ optional($proposal->valid_until)->format('d/m/Y') ?? '—' }}</dd>
        <dt class="col-sm-3">Arquivo</dt><dd class="col-sm-9"><code>{{ $proposal->file_path }}</code></dd>
    </dl>
</div></div>
@endsection
