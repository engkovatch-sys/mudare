<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $suppliers = Supplier::orderBy('name')->paginate(15);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('suppliers.create', ['supplier' => new Supplier()]);
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        Supplier::create($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor cadastrado com sucesso.');
    }

    public function edit(Supplier $supplier): View
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(StoreSupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor atualizado com sucesso.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor removido.');
    }
}
