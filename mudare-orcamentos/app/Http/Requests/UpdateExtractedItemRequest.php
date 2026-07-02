<?php

namespace App\Http\Requests;

use App\Enums\BudgetImpact;
use App\Enums\Criticality;
use App\Enums\FinishStandard;
use App\Enums\ValidationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExtractedItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_identified' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'subcategory' => ['nullable', 'string', 'max:255'],
            'environment' => ['nullable', 'string', 'max:255'],
            'technical_description' => ['nullable', 'string'],
            'suggested_unit' => ['nullable', 'string', 'max:50'],
            'identified_quantity' => ['nullable', 'string', 'max:100'],
            'budget_impact' => ['required', Rule::in(BudgetImpact::values())],
            'criticality' => ['required', Rule::in(Criticality::values())],
            'finish_standard' => ['required', Rule::in(FinishStandard::values())],
            'requires_specific_quote' => ['nullable', 'boolean'],
            'textual_evidence' => ['nullable', 'string'],
            'source_page' => ['nullable', 'string', 'max:50'],
            'confidence_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'specification_gaps' => ['nullable', 'string'],
            'human_validation_note' => ['nullable', 'string'],
            'validation_status' => ['required', Rule::in(ValidationStatus::values())],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'requires_specific_quote' => $this->boolean('requires_specific_quote'),
        ]);
    }
}
