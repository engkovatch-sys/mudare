<?php

namespace App\Http\Controllers;

use App\Models\Architect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchitectController extends Controller
{
    public function index(): View
    {
        $architects = Architect::orderBy('name')->paginate(15);

        return view('architects.index', compact('architects'));
    }

    public function create(): View
    {
        return view('architects.create', ['architect' => new Architect()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Architect::create($this->validated($request));

        return redirect()->route('architects.index')->with('success', 'Arquiteto cadastrado com sucesso.');
    }

    public function edit(Architect $architect): View
    {
        return view('architects.edit', compact('architect'));
    }

    public function update(Request $request, Architect $architect): RedirectResponse
    {
        $architect->update($this->validated($request));

        return redirect()->route('architects.index')->with('success', 'Arquiteto atualizado com sucesso.');
    }

    public function destroy(Architect $architect): RedirectResponse
    {
        $architect->delete();

        return redirect()->route('architects.index')->with('success', 'Arquiteto removido.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'office_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
