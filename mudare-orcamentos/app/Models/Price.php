<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    protected $fillable = [
        'supplier_id', 'item_name', 'category', 'unit', 'unit_price',
        'price_type', 'source', 'source_url', 'collected_at', 'valid_until',
        'taxes_included', 'freight_included', 'validation_responsible',
        'validation_status', 'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'collected_at' => 'date',
        'valid_until' => 'date',
        'taxes_included' => 'boolean',
        'freight_included' => 'boolean',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
