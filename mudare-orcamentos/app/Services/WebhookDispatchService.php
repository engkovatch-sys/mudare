<?php

namespace App\Services;

use App\Models\WebhookLog;
use App\Models\Work;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Dispara webhook para Make/Zapier. FALHA COM SEGURANÇA: qualquer erro é
 * registrado em webhook_logs e nunca derruba o fluxo principal.
 */
class WebhookDispatchService
{
    public function dispatchForWork(Work $work, ?string $targetUrl = null): WebhookLog
    {
        $targetUrl = $targetUrl ?: (string) env('WEBHOOK_DEFAULT_URL', '');

        $payload = $this->buildPayload($work);

        $log = new WebhookLog([
            'event' => 'work.summary',
            'target_url' => $targetUrl,
            'payload_json' => json_encode($payload, JSON_UNESCAPED_UNICODE),
            'sent_at' => now(),
        ]);

        if (blank($targetUrl)) {
            $log->response_status = 0;
            $log->response_body = 'URL de webhook não configurada (WEBHOOK_DEFAULT_URL vazio ou não informado).';
            $log->save();

            return $log;
        }

        // Proteção contra SSRF: só permitimos URLs http(s) públicas. Bloqueia
        // loopback, IPs privados/link-local/reservados e hosts que resolvam
        // para esses ranges (mitiga DNS rebinding).
        $urlError = $this->validatePublicUrl($targetUrl);
        if ($urlError !== null) {
            Log::warning('Webhook bloqueado por política de destino', ['reason' => $urlError]);
            $log->response_status = 0;
            $log->response_body = 'Webhook bloqueado: ' . $urlError;
            $log->save();

            return $log;
        }

        try {
            // withoutRedirecting evita bypass da validação via redirect.
            $response = Http::timeout(20)->withoutRedirecting()->asJson()->post($targetUrl, $payload);
            $log->response_status = $response->status();
            $log->response_body = mb_substr($response->body(), 0, 5000);
        } catch (\Throwable $e) {
            // Falha de rede/URL: registra sem quebrar o fluxo.
            Log::warning('Falha no webhook', ['message' => $e->getMessage()]);
            $log->response_status = 0;
            $log->response_body = 'Falha ao enviar webhook: ' . $e->getMessage();
        }

        $log->save();

        return $log;
    }

    /**
     * Valida que a URL de destino é http(s) pública. Retorna null se for
     * segura, ou uma mensagem de erro amigável caso contrário.
     */
    protected function validatePublicUrl(string $url): ?string
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return 'URL inválida.';
        }

        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        $host = $parts['host'] ?? '';

        if (! in_array($scheme, ['http', 'https'], true)) {
            return 'esquema não permitido (use http ou https).';
        }

        if ($host === '') {
            return 'host ausente.';
        }

        // Resolve o host para IP(s) e valida cada um. Se o host já for IP,
        // gethostbynamel retorna null; tratamos ambos os casos.
        $ips = [];
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $ips[] = $host;
        } else {
            $resolved = @gethostbynamel($host);
            if ($resolved === false || $resolved === null) {
                return 'não foi possível resolver o host.';
            }
            $ips = $resolved;
        }

        foreach ($ips as $ip) {
            if (! $this->isPublicIp($ip)) {
                return 'destino aponta para um endereço não público (privado/loopback/reservado).';
            }
        }

        return null;
    }

    protected function isPublicIp(string $ip): bool
    {
        // Rejeita ranges privados e reservados (inclui loopback e link-local).
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }

    protected function buildPayload(Work $work): array
    {
        $itemsCount = $work->extractedItems()->count();
        $alertsCount = $work->alerts()->whereNull('resolved_at')->count();
        $lastProposal = $work->proposals()->where('proposal_type', 'commercial')->latest('generated_at')->first();

        return [
            'work_id' => $work->id,
            'obra' => $work->name,
            'cliente' => optional($work->client)->name,
            'status' => $work->status,
            'quantidade_itens_extraidos' => $itemsCount,
            'quantidade_alertas' => $alertsCount,
            'valor_total_estimado' => $lastProposal ? (float) $lastProposal->total_amount : null,
            'link_interno' => url('/works/' . $work->id),
            'data_envio' => now()->toIso8601String(),
        ];
    }
}
