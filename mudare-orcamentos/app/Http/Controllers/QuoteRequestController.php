<?php

namespace App\Http\Controllers;

use App\Models\ExtractedItem;
use App\Models\QuoteRequest;
use App\Models\Supplier;
use App\Models\Work;
use App\Services\QuoteEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function __construct(protected QuoteEmailService $quoteEmail)
    {
    }

    public function index(): View
    {
        $quoteRequests = QuoteRequest::with(['work', 'supplier', 'extractedItem'])
            ->latest()->paginate(15);

        return view('quotes.index', compact('quoteRequests'));
    }

    public function create(Request $request): View
    {
        $item = $request->filled('extracted_item_id')
            ? ExtractedItem::with('work')->find($request->input('extracted_item_id'))
            : null;

        $suggestedBody = '';
        $suggestedSubject = '';
        if ($item && $item->work) {
            $suggestedBody = $this->quoteEmail->buildBody($item->work, $item);
            $suggestedSubject = $this->quoteEmail->subjectFor($item->work, $item);
        }

        return view('quotes.create', [
            'quoteRequest' => new QuoteRequest([
                'work_id' => $item?->work_id ?? $request->input('work_id'),
                'extracted_item_id' => $item?->id,
                'subject' => $suggestedSubject,
                'body' => $suggestedBody,
                'status' => 'draft',
            ]),
            'works' => Work::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
            'items' => ExtractedItem::orderBy('item_identified')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        QuoteRequest::create($data);

        return redirect()->route('quote-requests.index')->with('success', 'Solicitação de cotação registrada.');
    }

    public function show(QuoteRequest $quoteRequest): View
    {
        $quoteRequest->load(['work', 'supplier', 'extractedItem']);

        return view('quotes.show', compact('quoteRequest'));
    }

    public function edit(QuoteRequest $quoteRequest): View
    {
        return view('quotes.create', [
            'quoteRequest' => $quoteRequest,
            'works' => Work::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
            'items' => ExtractedItem::orderBy('item_identified')->get(),
        ]);
    }

    public function update(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $quoteRequest->update($this->validated($request));

        return redirect()->route('quote-requests.show', $quoteRequest)->with('success', 'Cotação atualizada.');
    }

    public function destroy(QuoteRequest $quoteRequest): RedirectResponse
    {
        $quoteRequest->delete();

        return redirect()->route('quote-requests.index')->with('success', 'Cotação removida.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'work_id' => ['nullable', 'exists:works,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'extracted_item_id' => ['nullable', 'exists:extracted_items,id'],
            'subject' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'sent_at' => ['nullable', 'date'],
            'response_received_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
