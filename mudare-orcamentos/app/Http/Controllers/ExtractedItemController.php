<?php

namespace App\Http\Controllers;

use App\Enums\BudgetImpact;
use App\Enums\Criticality;
use App\Enums\FinishStandard;
use App\Enums\ValidationStatus;
use App\Http\Requests\UpdateExtractedItemRequest;
use App\Models\ExtractedItem;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExtractedItemController extends Controller
{
    public function index(Work $work): View
    {
        $items = $work->extractedItems()->orderBy('category')->orderBy('item_identified')->get();

        return view('extracted-items.index', compact('work', 'items'));
    }

    public function edit(ExtractedItem $extractedItem): View
    {
        $extractedItem->load('work');

        return view('extracted-items.edit', [
            'item' => $extractedItem,
            'budgetImpacts' => BudgetImpact::cases(),
            'criticalities' => Criticality::cases(),
            'finishStandards' => FinishStandard::cases(),
            'validationStatuses' => ValidationStatus::cases(),
        ]);
    }

    public function update(UpdateExtractedItemRequest $request, ExtractedItem $extractedItem): RedirectResponse
    {
        $data = $request->validated();

        // Registra quem/quando validou quando o status muda de pending.
        if (($data['validation_status'] ?? null) !== 'pending'
            && $data['validation_status'] !== $extractedItem->validation_status) {
            $data['validated_by'] = Auth::user()?->name ?? Auth::user()?->email;
            $data['validated_at'] = now();
        }

        $extractedItem->update($data);

        return redirect()
            ->route('works.extracted-items.index', $extractedItem->work_id)
            ->with('success', 'Item atualizado. Status: ' . $extractedItem->validation_status . '.');
    }
}
