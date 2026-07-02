<?php

namespace App\Http\Controllers;

use App\Models\Architect;
use App\Models\BudgetAlert;
use App\Models\Client;
use App\Models\ExtractedItem;
use App\Models\Proposal;
use App\Models\Supplier;
use App\Models\Work;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'works' => Work::count(),
            'clients' => Client::count(),
            'architects' => Architect::count(),
            'suppliers' => Supplier::count(),
            'items' => ExtractedItem::count(),
            'items_pending' => ExtractedItem::where('validation_status', 'pending')->count(),
            'alerts_open' => BudgetAlert::whereNull('resolved_at')->count(),
            'alerts_critical' => BudgetAlert::whereNull('resolved_at')->where('severity', 'critico')->count(),
            'proposals' => Proposal::count(),
        ];

        $recentWorks = Work::with(['client', 'architect'])->latest()->take(6)->get();

        return view('dashboard.index', compact('stats', 'recentWorks'));
    }
}
