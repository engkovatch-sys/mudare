@extends('layouts.app')
@section('title', 'Alertas técnicos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h3 mb-0">Alertas técnicos (malha fina)</h1>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('works.fine-comb', $work) }}">
            @csrf
            <button class="btn btn-brand">Rodar malha fina novamente</button>
        </form>
        <a href="{{ route('works.show', $work) }}" class="btn btn-outline-secondary">Voltar à obra</a>
    </div>
</div>
<p class="text-muted">Obra: <strong>{{ $work->name }}</strong>. Sinalizações técnicas — não substituem o engenheiro orçamentista.</p>

@forelse ($alerts as $alert)
    <div class="card mb-2 border-start border-4" style="border-color: {{ $alert->severity->value === 'critico' ? '#dc3545' : ($alert->severity->value === 'alto' ? '#fd7e14' : '#6c757d') }} !important">
        <div class="card-body py-2">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge {{ $alert->severity->badgeClass() }}">{{ $alert->severity->label() }}</span>
                    <span class="badge bg-light text-dark border">{{ $alert->alert_type }}</span>
                    <strong class="ms-1">{{ $alert->description }}</strong>
                    <div class="small text-muted mt-1">
                        @if($alert->current_value)Atual: {{ $alert->current_value }} · @endif
                        @if($alert->reference_value)Referência: {{ $alert->reference_value }} · @endif
                        @if($alert->deviation_percentage !== null)Desvio: {{ $alert->deviation_percentage }}% @endif
                    </div>
                    @if($alert->evidence)<div class="small mt-1"><em>{{ $alert->evidence }}</em></div>@endif
                    @if($alert->recommended_action)<div class="small mt-1 text-brand">➜ {{ $alert->recommended_action }}</div>@endif
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-success">Nenhum alerta aberto. Rode a malha fina para gerar as verificações.</div>
@endforelse
@endsection
