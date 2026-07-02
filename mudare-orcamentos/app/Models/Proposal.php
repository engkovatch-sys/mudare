<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    protected $fillable = [
        'work_id', 'proposal_type', 'title', 'file_path', 'total_amount',
        'status', 'generated_at', 'valid_until', 'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'generated_at' => 'datetime',
        'valid_until' => 'date',
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }
}
