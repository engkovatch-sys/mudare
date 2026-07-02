<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<style>
    @page { margin: 40px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; }
    h1 { font-size: 20px; color: {{ $brandColor }}; margin: 0 0 2px; }
    h2 { font-size: 13px; border-bottom: 2px solid {{ $brandColor }}; padding-bottom: 3px; margin-top: 20px; color: {{ $brandColor }}; }
    table { width: 100%; border-collapse: collapse; margin-top: 6px; }
    th, td { border: 1px solid #ccc; padding: 4px 5px; text-align: left; vertical-align: top; }
    th { background: #f0f0f0; font-size: 9px; text-transform: uppercase; }
    .muted { color: #777; }
    .tag { display: inline-block; padding: 1px 5px; border-radius: 3px; font-size: 8px; color: #fff; }
    .crit { background: #dc3545; } .alto { background: #fd7e14; } .medio { background: #0d6efd; }
    .baixo { background: #6c757d; } .info { background: #0dcaf0; color:#222; }
    .footer-note { text-align: center; font-style: italic; color: {{ $brandColor }}; margin-top: 24px; }
    .warn { background: #fff3cd; }
</style>
</head>
<body>

<h1>Relatório Técnico Interno</h1>
<div class="muted">Uso exclusivo da engenharia / orçamento — NÃO enviar ao cliente.</div>

<h2>Dados da obra</h2>
<table>
    <tr><th style="width:25%">Obra</th><td>{{ $work->name }}</td></tr>
    <tr><th>Cliente / Arquiteto</th><td>{{ optional($work->client)->name ?? 'não identificado' }} / {{ optional($work->architect)->name ?? 'não identificado' }}</td></tr>
    <tr><th>Área / Padrão</th><td>{{ $work->built_area ? number_format($work->built_area,2,',','.').' m²' : 'não identificado' }} — {{ $work->finish_standard }}</td></tr>
    <tr><th>Data-base</th><td>{{ optional($work->budget_base_date)->format('d/m/Y') ?? 'não identificado' }}</td></tr>
    <tr><th>Gerado em</th><td>{{ $generatedAt->format('d/m/Y H:i') }}</td></tr>
</table>

<h2>Itens extraídos ({{ $items->count() }})</h2>
<table>
    <thead><tr><th>Item</th><th>Categoria</th><th>Ambiente</th><th>Unid.</th><th>Qtd.</th><th>Crit.</th><th>Conf.</th><th>Validação</th></tr></thead>
    <tbody>
    @forelse($items as $i)
        <tr @if($i->validation_status !== 'approved') class="warn" @endif>
            <td>{{ $i->item_identified }}</td>
            <td>{{ $i->category }}</td>
            <td>{{ $i->environment }}</td>
            <td>{{ $i->suggested_unit }}</td>
            <td>{{ $i->identified_quantity }}</td>
            <td>{{ $i->criticality }}</td>
            <td>{{ $i->confidence_score }}%</td>
            <td>{{ $i->validation_status }}</td>
        </tr>
    @empty
        <tr><td colspan="8" class="muted">Nenhum item extraído.</td></tr>
    @endforelse
    </tbody>
</table>

<h2>Itens sem evidência textual ({{ $withoutEvidence->count() }})</h2>
@if($withoutEvidence->count())
<ul>@foreach($withoutEvidence as $i)<li>{{ $i->item_identified }} ({{ $i->category }})</li>@endforeach</ul>
@else<p class="muted">Todos os itens possuem evidência textual.</p>@endif

<h2>Itens não aprovados / estimados ({{ $estimatedOrPending->count() }})</h2>
@if($estimatedOrPending->count())
<ul>@foreach($estimatedOrPending as $i)<li>{{ $i->item_identified }} — status: {{ $i->validation_status }}</li>@endforeach</ul>
@else<p class="muted">Todos os itens estão aprovados.</p>@endif

<h2>Lacunas de especificação ({{ $withGaps->count() }})</h2>
@if($withGaps->count())
<table>
    <thead><tr><th>Item</th><th>Lacunas</th></tr></thead>
    <tbody>
    @foreach($withGaps as $i)<tr><td>{{ $i->item_identified }}</td><td>{{ $i->specification_gaps }}</td></tr>@endforeach
    </tbody>
</table>
@else<p class="muted">Nenhuma lacuna de especificação registrada.</p>@endif

<h2>Alertas da malha fina ({{ $alerts->count() }})</h2>
@if($alerts->count())
<table>
    <thead><tr><th>Sev.</th><th>Tipo</th><th>Descrição</th><th>Ação recomendada</th></tr></thead>
    <tbody>
    @foreach($alerts as $a)
        @php $sev = $a->severity->value; @endphp
        <tr>
            <td><span class="tag {{ $sev==='critico'?'crit':($sev==='alto'?'alto':($sev==='medio'?'medio':($sev==='baixo'?'baixo':'info'))) }}">{{ $a->severity->label() }}</span></td>
            <td>{{ $a->alert_type }}</td>
            <td>{{ $a->description }}</td>
            <td>{{ $a->recommended_action }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@else<p class="muted">Nenhum alerta. Rode a malha fina para gerar verificações.</p>@endif

<h2>Recomendações para revisão do engenheiro</h2>
<ul>
    <li>Validar todos os itens críticos e sob cotação antes de emitir a proposta comercial.</li>
    <li>Confirmar quantidades e unidades normalizadas.</li>
    <li>Fechar cotações formais dos itens sob medida.</li>
    <li>Rever itens sem evidência textual e com baixa confiança.</li>
</ul>

<div class="footer-note">O rigor da engenharia para a arte da arquitetura</div>

</body>
</html>
