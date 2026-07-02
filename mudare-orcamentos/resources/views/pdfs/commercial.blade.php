<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<style>
    @page { margin: 120px 40px 80px 40px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
    .brand { color: {{ $brandColor }}; }
    h1 { font-size: 22px; margin: 0 0 4px; }
    h2 { font-size: 14px; border-bottom: 2px solid {{ $brandColor }}; padding-bottom: 3px; margin-top: 22px; color: {{ $brandColor }}; }
    .cover { text-align: center; padding-top: 160px; }
    .cover h1 { font-size: 30px; }
    table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    th, td { border: 1px solid #ccc; padding: 5px 6px; text-align: left; }
    th { background: #f0f0f0; font-size: 10px; text-transform: uppercase; }
    td.num, th.num { text-align: right; }
    .muted { color: #777; }
    .totals td { border: none; padding: 3px 6px; }
    .totals .grand { font-size: 15px; font-weight: bold; color: {{ $brandColor }}; border-top: 2px solid {{ $brandColor }}; }
    ul { margin: 4px 0 4px 16px; padding: 0; }
    .footer-note { text-align: center; font-style: italic; color: {{ $brandColor }}; margin-top: 24px; }
    .page-break { page-break-before: always; }
</style>
</head>
<body>

<div class="cover">
    <div class="brand" style="font-size:14px; letter-spacing:3px;">◆ ORÇAMENTOS ALTO PADRÃO</div>
    <h1 class="brand">Proposta Comercial</h1>
    <p style="font-size:16px; margin-top:20px;">{{ $work->name }}</p>
    <p class="muted">
        {{ optional($client)->name ?? 'Cliente não identificado' }}
        @if($work->city) — {{ $work->city }}/{{ $work->state }} @endif
    </p>
    <p class="muted" style="margin-top:40px;">Gerada em {{ $generatedAt->format('d/m/Y') }}</p>
    @if($work->proposal_version)<p class="muted">Versão {{ $work->proposal_version }}</p>@endif
</div>

<div class="page-break"></div>

<h2>1. Dados da obra</h2>
<table>
    <tr><th style="width:30%">Obra</th><td>{{ $work->name }}</td></tr>
    <tr><th>Cliente</th><td>{{ optional($client)->name ?? 'não identificado' }}</td></tr>
    <tr><th>Arquiteto</th><td>{{ optional($architect)->name ?? 'não identificado' }}</td></tr>
    <tr><th>Endereço</th><td>{{ $work->address ?? 'não identificado' }} {{ $work->city ? ' - '.$work->city.'/'.$work->state : '' }}</td></tr>
    <tr><th>Área construída</th><td>{{ $work->built_area ? number_format($work->built_area,2,',','.').' m²' : 'não identificado' }}</td></tr>
    <tr><th>Padrão de acabamento</th><td>{{ $work->finish_standard }}</td></tr>
    <tr><th>Data-base</th><td>{{ optional($work->budget_base_date)->format('d/m/Y') ?? 'não identificado' }}</td></tr>
    <tr><th>Validade da proposta</th><td>{{ optional($work->proposal_valid_until)->format('d/m/Y') ?? 'a combinar' }}</td></tr>
</table>

<h2>2. Premissas e escopo</h2>
<p><strong>Premissas:</strong> Proposta elaborada com base no memorial descritivo fornecido e itens tecnicamente validados.
Especificações não constantes no memorial estão marcadas como "não identificado" e serão objeto de definição em projeto executivo.</p>
<p><strong>Escopo incluso:</strong> fornecimento e execução dos itens tecnicamente aprovados listados na composição de custo direto.</p>
<p><strong>Escopo excluído:</strong> itens não descritos no memorial; taxas, licenças e projetos de terceiros; itens sujeitos à cotação formal ainda não fechados.</p>

<h2>3. Resumo executivo</h2>
<p>Esta proposta contempla {{ $composition->count() }} item(ns) de custo direto validado(s) para a obra
<strong>{{ $work->name }}</strong>, padrão <strong>{{ $work->finish_standard }}</strong>.</p>

<h2>4. Composição de custo direto</h2>
<table>
    <thead><tr><th>Item</th><th>Categoria</th><th>Unid.</th><th class="num">Qtd.</th><th class="num">Preço unit.</th><th class="num">Total</th></tr></thead>
    <tbody>
    @forelse ($composition as $row)
        <tr>
            <td>{{ $row->item }}</td>
            <td>{{ $row->category }}</td>
            <td>{{ $row->unit }}</td>
            <td class="num">{{ number_format($row->quantity, 2, ',', '.') }}</td>
            <td class="num">{{ $row->has_price ? 'R$ '.number_format($row->unit_price,2,',','.') : 'a cotar' }}</td>
            <td class="num">R$ {{ number_format($row->total,2,',','.') }}</td>
        </tr>
    @empty
        <tr><td colspan="6" class="muted">Nenhum item aprovado. Aprove itens na revisão para compor o custo.</td></tr>
    @endforelse
    </tbody>
</table>

<h2>5. Custos indiretos, administração e BDI</h2>
<table class="totals">
    <tr><td>Custo direto</td><td class="num">R$ {{ number_format($directCost,2,',','.') }}</td></tr>
    <tr><td>Custos indiretos ({{ number_format($indirectRate*100,1,',','.') }}%)</td><td class="num">R$ {{ number_format($indirect,2,',','.') }}</td></tr>
    <tr><td>Taxa de administração ({{ number_format($adminRate*100,1,',','.') }}%)</td><td class="num">R$ {{ number_format($admin,2,',','.') }}</td></tr>
    <tr><td>BDI ({{ number_format($bdiRate*100,2,',','.') }}%)</td><td class="num">R$ {{ number_format($bdi,2,',','.') }}</td></tr>
    <tr class="grand"><td>VALOR TOTAL</td><td class="num">R$ {{ number_format($total,2,',','.') }}</td></tr>
</table>

<h2>6. Itens sujeitos à cotação</h2>
@if($quoteItems->count())
<ul>
    @foreach($quoteItems as $qi)
        <li>{{ $qi->item_identified }} — {{ $qi->category }} ({{ $qi->environment }})</li>
    @endforeach
</ul>
<p class="muted">Os itens acima serão confirmados após cotação formal com fornecedores especializados.</p>
@else
<p class="muted">Nenhum item sujeito à cotação formal identificado.</p>
@endif

<h2>7. Riscos e condicionantes comerciais</h2>
<ul>
    <li>Valores referenciados à data-base indicada; sujeitos a reajuste conforme índices.</li>
    <li>Itens sob cotação podem alterar o valor final após fechamento com fornecedores.</li>
    <li>Alterações de projeto implicam revisão orçamentária.</li>
</ul>

<h2>8. Cronograma macro</h2>
<p class="muted">Cronograma detalhado a ser desenvolvido na fase de planejamento executivo, considerando prazos de fornecimento de itens especiais/importados.</p>

<h2>9. Diferenciais técnicos</h2>
<ul>
    <li>Rigor de engenharia orçamentária com malha fina técnica.</li>
    <li>Rastreabilidade de preços e validação humana obrigatória.</li>
    <li>Atenção especial a interfaces críticas (impermeabilização, esquadrias, instalações).</li>
</ul>

<h2>10. Fechamento</h2>
<p>Colocamo-nos à disposição para esclarecimentos e ajustes de escopo.</p>

<div class="footer-note">O rigor da engenharia para a arte da arquitetura</div>

</body>
</html>
