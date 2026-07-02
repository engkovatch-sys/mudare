<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Architect extends Model
{
    protected $fillable = [
        'name', 'office_name', 'email', 'phone', 'website', 'instagram', 'notes',
    ];

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }
}
