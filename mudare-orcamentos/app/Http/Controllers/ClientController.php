<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::orderBy('name')->paginate(15);

        return view('clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('clients.create', ['client' => new Client()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Client::create($this->validated($request));

        return redirect()->route('clients.index')->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $client->update($this->validated($request));

        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente removido.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'document' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
