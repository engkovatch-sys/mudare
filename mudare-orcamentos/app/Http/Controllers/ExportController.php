<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Services\CsvExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function __construct(protected CsvExportService $csv)
    {
    }

    /**
     * Exporta CSV (itens, preços, alertas, proposta resumida) e faz o
     * download por controller — não depende de storage:link.
     */
    public function csv(Request $request, Work $work): BinaryFileResponse
    {
        $type = $request->query('type', 'items');
        $allowed = ['items', 'prices', 'alerts', 'proposal'];
        if (! in_array($type, $allowed, true)) {
            $type = 'items';
        }

        $relativePath = $this->csv->export($work, $type);
        $absolute = Storage::disk('local')->path($relativePath);

        return response()->download($absolute, basename($relativePath))
            ->deleteFileAfterSend(false);
    }
}
