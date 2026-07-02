<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetHistory extends Model
{
    protected $table = 'budget_history';

    protected $fillable = [
        'category', 'item_name', 'environment', 'unit', 'unit_price',
        'quantity_per_m2', 'finish_standard', 'city', 'state', 'base_date',
        'source', 'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity_per_m2' => 'decimal:4',
        'base_date' => 'date',
    ];
}
