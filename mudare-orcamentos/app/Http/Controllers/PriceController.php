<?php

namespace App\Http\Controllers;

use App\Enums\PriceType;
use App\Enums\ValidationStatus;
use App\Http\Requests\StorePriceRequest;
use App\Models\Price;
use App\Models\Supplier;
use App\Services\PriceTraceabilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function __construct(protected PriceTraceabilityService $traceability)
    {
    }

    public function index(): View
    {
        $prices = Price::with('supplier')->latest()->paginate(15);

        return view('prices.index', [
            'prices' => $prices,
            'traceability' => $this->traceability,
        ]);
    }

    public function create(): View
    {
        return view('prices.create', [
            'price' => new Price(['price_type' => 'estimado', 'validation_status' => 'pending']),
            'suppliers' => Supplier::orderBy('name')->get(),
            'priceTypes' => PriceType::cases(),
            'validationStatuses' => ValidationStatus::cases(),
        ]);
    }

    public function store(StorePriceRequest $request): RedirectResponse
    {
        Price::create($request->validated());

        return redirect()->route('prices.index')->with('success', 'Preço cadastrado com rastreabilidade.');
    }

    public function edit(Price $price): View
    {
        return view('prices.edit', [
            'price' => $price,
            'suppliers' => Supplier::orderBy('name')->get(),
            'priceTypes' => PriceType::cases(),
            'validationStatuses' => ValidationStatus::cases(),
        ]);
    }

    public function update(StorePriceRequest $request, Price $price): RedirectResponse
    {
        $price->update($request->validated());

        return redirect()->route('prices.index')->with('success', 'Preço atualizado.');
    }

    public function destroy(Price $price): RedirectResponse
    {
        $price->delete();

        return redirect()->route('prices.index')->with('success', 'Preço removido.');
    }
}
