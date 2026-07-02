<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemorialRequest;
use App\Models\Memorial;
use App\Models\Work;
use App\Services\AnthropicExtractionService;
use App\Services\MemorialTextExtractorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemorialController extends Controller
{
    public function __construct(
        protected MemorialTextExtractorService $extractor,
        protected AnthropicExtractionService $anthropic,
    ) {
    }

    public function create(Work $work): View
    {
        return view('memorials.create', compact('work'));
    }

    public function store(StoreMemorialRequest $request, Work $work): RedirectResponse
    {
        $extractedText = null;
        $storedPath = null;
        $originalName = null;
        $extractionMode = 'manual_text';
        $errorMessage = null;

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $originalName = $file->getClientOriginalName();
            // Armazenado FORA da pasta pública (storage/app/memorials).
            $storedPath = $file->store('memorials', 'local');

            $absolute = Storage::disk('local')->path($storedPath);
            $result = $this->extractor->extractFromFile($absolute);

            if ($result['success']) {
                $extractedText = $result['text'];
                $extractionMode = $request->filled('manual_text') ? 'mixed' : 'pdf_auto';
            } else {
                // Extração falhou: fallback manual continua funcionando.
                $errorMessage = $result['error'];
                $extractionMode = $request->filled('manual_text') ? 'manual_text' : 'manual_text';
            }
        }

        $memorial = $work->memorials()->create([
            'original_filename' => $originalName,
            'stored_path' => $storedPath,
            'extracted_text' => $extractedText,
            'manual_text' => $request->input('manual_text'),
            'extraction_mode' => $extractionMode,
            'processing_status' => 'pending',
            'error_message' => $errorMessage,
        ]);

        $flash = 'Memorial salvo. ';
        if ($errorMessage) {
            $flash .= 'Aviso: ' . $errorMessage . ' ';
        }
        $flash .= 'Agora você pode processar com a IA.';

        return redirect()->route('memorials.show', $memorial)->with('success', $flash);
    }

    public function show(Memorial $memorial): View
    {
        $memorial->load(['work', 'extractedItems']);

        return view('memorials.show', [
            'memorial' => $memorial,
            'anthropicConfigured' => $this->anthropic->isConfigured(),
        ]);
    }

    public function process(Memorial $memorial): RedirectResponse
    {
        $memorial->update(['processing_status' => 'processing']);

        $result = $this->anthropic->processMemorial($memorial);

        if ($result['success']) {
            $memorial->update([
                'processing_status' => 'processed',
                'processed_at' => now(),
                'error_message' => null,
            ]);

            return redirect()
                ->route('works.extracted-items.index', $memorial->work_id)
                ->with('success', $result['message']);
        }

        $memorial->update([
            'processing_status' => 'failed',
            'error_message' => $result['message'],
        ]);

        return redirect()->route('memorials.show', $memorial)->with('error', $result['message']);
    }
}
