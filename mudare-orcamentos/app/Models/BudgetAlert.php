<?php

namespace App\Models;

use App\Enums\AlertSeverity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetAlert extends Model
{
    protected $fillable = [
        'work_id', 'extracted_item_id', 'alert_type', 'description', 'severity',
        'category', 'environment', 'current_value', 'reference_value',
        'deviation_percentage', 'evidence', 'recommended_action',
        'human_validation_required', 'resolved_at',
    ];

    protected $casts = [
        'deviation_percentage' => 'decimal:2',
        'human_validation_required' => 'boolean',
        'resolved_at' => 'datetime',
        'severity' => AlertSeverity::class,
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function extractedItem(): BelongsTo
    {
        return $this->belongsTo(ExtractedItem::class);
    }
}
