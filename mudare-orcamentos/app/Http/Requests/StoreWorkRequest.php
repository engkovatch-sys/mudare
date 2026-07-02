<?php

namespace App\Http\Requests;

use App\Enums\FinishStandard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['nullable', 'exists:clients,id'],
            'architect_id' => ['nullable', 'exists:architects,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:2'],
            'built_area' => ['nullable', 'numeric', 'min:0'],
            'finish_standard' => ['required', Rule::in(FinishStandard::values())],
            'budget_base_date' => ['nullable', 'date'],
            'proposal_version' => ['nullable', 'string', 'max:50'],
            'proposal_valid_until' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
