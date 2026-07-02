<?php

namespace App\Http\Requests;

use App\Enums\PriceType;
use App\Enums\ValidationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'item_name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:50'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'price_type' => ['required', Rule::in(PriceType::values())],
            'source' => ['nullable', 'string', 'max:255'],
            'source_url' => ['nullable', 'string', 'max:500'],
            'collected_at' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
            'taxes_included' => ['nullable', 'boolean'],
            'freight_included' => ['nullable', 'boolean'],
            'validation_responsible' => ['nullable', 'string', 'max:255'],
            'validation_status' => ['nullable', Rule::in(ValidationStatus::values())],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'taxes_included' => $this->boolean('taxes_included'),
            'freight_included' => $this->boolean('freight_included'),
        ]);
    }
}
