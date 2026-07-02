<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Confirmação explícita para gerar a proposta comercial mesmo
            // havendo itens críticos pendentes (segurança).
            'confirm_critical' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'confirm_critical' => $this->boolean('confirm_critical'),
        ]);
    }
}
