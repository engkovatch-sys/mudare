<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name', 'document', 'email', 'phone', 'address', 'notes',
    ];

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }
}
