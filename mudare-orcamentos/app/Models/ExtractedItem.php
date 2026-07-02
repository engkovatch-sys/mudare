<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExtractedItem extends Model
{
    protected $fillable = [
        'work_id', 'memorial_id', 'item_identified', 'category', 'subcategory',
        'environment', 'technical_description', 'suggested_unit', 'identified_quantity',
        'budget_impact', 'criticality', 'finish_standard', 'requires_specific_quote',
        'textual_evidence', 'source_page', 'confidence_score', 'specification_gaps',
        'human_validation_note', 'validation_status', 'validated_by', 'validated_at',
        'raw_payload_json',
    ];

    protected $casts = [
        'requires_specific_quote' => 'boolean',
        'confidence_score' => 'integer',
        'validated_at' => 'datetime',
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(BudgetAlert::class);
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function isApproved(): bool
    {
        return $this->validation_status === 'approved';
    }
}
