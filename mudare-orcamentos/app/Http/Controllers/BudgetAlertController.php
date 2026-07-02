<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Services\BudgetFineCombService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BudgetAlertController extends Controller
{
    public function __construct(protected BudgetFineCombService $fineComb)
    {
    }

    /**
     * Executa a malha fina orçamentária para a obra (regenera alertas).
     */
    public function fineComb(Work $work): RedirectResponse
    {
        $result = $this->fineComb->run($work);

        return redirect()
            ->route('works.alerts.index', $work)
            ->with('success', "Malha fina executada: {$result['alerts_created']} alerta(s) gerado(s).");
    }

    public function index(Work $work): View
    {
        $alerts = $work->alerts()
            ->with('extractedItem')
            ->orderByRaw("CASE severity WHEN 'critico' THEN 1 WHEN 'alto' THEN 2 WHEN 'medio' THEN 3 WHEN 'baixo' THEN 4 ELSE 5 END")
            ->get();

        return view('alerts.index', compact('work', 'alerts'));
    }
}
