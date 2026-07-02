<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    protected $fillable = [
        'work_id', 'supplier_id', 'extracted_item_id', 'subject', 'body',
        'status', 'sent_at', 'response_received_at', 'notes',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'response_received_at' => 'datetime',
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function extractedItem(): BelongsTo
    {
        return $this->belongsTo(ExtractedItem::class);
    }
}
