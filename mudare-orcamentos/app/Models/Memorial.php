<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Memorial extends Model
{
    protected $fillable = [
        'work_id', 'original_filename', 'stored_path', 'extracted_text',
        'manual_text', 'extraction_mode', 'processing_status', 'processed_at',
        'error_message',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function extractedItems(): HasMany
    {
        return $this->hasMany(ExtractedItem::class);
    }

    /**
     * Texto efetivo para processamento: combina o texto extraído do PDF
     * com o texto colado manualmente (fallback obrigatório do MVP).
     */
    public function effectiveText(): string
    {
        $parts = array_filter([
            trim((string) $this->extracted_text),
            trim((string) $this->manual_text),
        ]);

        return trim(implode("\n\n", $parts));
    }
}
