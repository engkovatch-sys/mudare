<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $fillable = [
        'event', 'target_url', 'payload_json', 'response_status',
        'response_body', 'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
