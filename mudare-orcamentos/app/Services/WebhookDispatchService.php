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

        try {
            $response = Http::timeout(20)->asJson()->post($targetUrl, $payload);
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
