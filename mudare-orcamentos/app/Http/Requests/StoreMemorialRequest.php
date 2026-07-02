<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemorialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // PDF opcional, mas mime e tamanho validados (máx. 20 MB).
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            // Fallback obrigatório funcional: exige PDF OU texto manual.
            'manual_text' => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (! $this->hasFile('pdf') && blank($this->input('manual_text'))) {
                $validator->errors()->add(
                    'manual_text',
                    'Envie um PDF ou cole o texto do memorial manualmente (fallback obrigatório).'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'pdf.mimes' => 'O arquivo deve ser um PDF.',
            'pdf.max' => 'O PDF não pode exceder 20 MB.',
        ];
    }
}
