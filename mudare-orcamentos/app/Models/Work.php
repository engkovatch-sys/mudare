<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Work extends Model
{
    protected $fillable = [
        'client_id', 'architect_id', 'name', 'address', 'city', 'state',
        'built_area', 'finish_standard', 'budget_base_date', 'proposal_version',
        'proposal_valid_until', 'status', 'notes',
    ];

    protected $casts = [
        'built_area' => 'decimal:2',
        'budget_base_date' => 'date',
        'proposal_valid_until' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function architect(): BelongsTo
    {
        return $this->belongsTo(Architect::class);
    }

    public function memorials(): HasMany
    {
        return $this->hasMany(Memorial::class);
    }

    public function extractedItems(): HasMany
    {
        return $this->hasMany(ExtractedItem::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(BudgetAlert::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }
}
