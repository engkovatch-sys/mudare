<?php

use App\Http\Controllers\ArchitectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetAlertController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExtractedItemController;
use App\Http\Controllers\MemorialController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Raiz: redireciona conforme autenticação.
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Autenticação (sem starter kit / sem Node).
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUDs
    Route::resource('clients', ClientController::class)->except(['show']);
    Route::resource('architects', ArchitectController::class)->except(['show']);
    Route::resource('works', WorkController::class);
    Route::resource('suppliers', SupplierController::class)->except(['show']);
    Route::resource('prices', PriceController::class)->except(['show']);
    Route::resource('quote-requests', QuoteRequestController::class);

    // Memoriais
    Route::get('/works/{work}/memorials/create', [MemorialController::class, 'create'])->name('memorials.create');
    Route::post('/works/{work}/memorials', [MemorialController::class, 'store'])->name('memorials.store');
    Route::get('/memorials/{memorial}', [MemorialController::class, 'show'])->name('memorials.show');
    Route::post('/memorials/{memorial}/process', [MemorialController::class, 'process'])->name('memorials.process');

    // Itens extraídos
    Route::get('/works/{work}/extracted-items', [ExtractedItemController::class, 'index'])->name('works.extracted-items.index');
    Route::get('/extracted-items/{extractedItem}/edit', [ExtractedItemController::class, 'edit'])->name('extracted-items.edit');
    Route::put('/extracted-items/{extractedItem}', [ExtractedItemController::class, 'update'])->name('extracted-items.update');

    // Malha fina + alertas
    Route::post('/works/{work}/fine-comb', [BudgetAlertController::class, 'fineComb'])->name('works.fine-comb');
    Route::get('/works/{work}/alerts', [BudgetAlertController::class, 'index'])->name('works.alerts.index');

    // Propostas / PDFs
    Route::get('/works/{work}/proposals', [ProposalController::class, 'index'])->name('works.proposals.index');
    Route::post('/works/{work}/proposals/commercial', [ProposalController::class, 'commercial'])->name('works.proposals.commercial');
    Route::post('/works/{work}/proposals/internal', [ProposalController::class, 'internal'])->name('works.proposals.internal');
    Route::get('/proposals/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');
    Route::get('/proposals/{proposal}/download', [ProposalController::class, 'download'])->name('proposals.download');

    // Exportação CSV
    Route::get('/works/{work}/export/csv', [ExportController::class, 'csv'])->name('works.export.csv');

    // Webhook Make/Zapier
    Route::post('/works/{work}/webhook', [WebhookController::class, 'dispatch'])->name('works.webhook');
});
