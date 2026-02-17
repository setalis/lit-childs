<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestMatchPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'left_text',
        'right_text',
        'right_image_path',
        'is_distractor',
        'order',
    ];

    /**
     * Унікальний ідентифікатор правої частини (текст або шлях до зображення).
     */
    public function getRightValueAttribute(): ?string
    {
        return $this->right_image_path ?? $this->right_text;
    }

    /**
     * Повний URL зображення правої частини.
     */
    public function getRightImageUrlAttribute(): ?string
    {
        return $this->right_image_path
            ? asset('storage/'.$this->right_image_path)
            : null;
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(TestQuestion::class, 'question_id');
    }
}
