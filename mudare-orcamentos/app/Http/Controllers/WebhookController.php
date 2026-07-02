<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Services\WebhookDispatchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __construct(protected WebhookDispatchService $webhook)
    {
    }

    public function dispatch(Request $request, Work $work): RedirectResponse
    {
        $targetUrl = $request->input('target_url') ?: null;

        $log = $this->webhook->dispatchForWork($work, $targetUrl);

        // Falha no webhook NÃO quebra o fluxo: sempre retornamos com mensagem.
        if ($log->response_status && $log->response_status >= 200 && $log->response_status < 300) {
            return back()->with('success', 'Webhook enviado com sucesso (HTTP ' . $log->response_status . ').');
        }

        return back()->with('error', 'Webhook registrado com falha: ' . ($log->response_body ?: 'sem resposta') . ' (log #' . $log->id . ').');
    }
}
