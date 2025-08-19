<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'term_definition_id',
        'image_path',
        'alt_text',
        'sort_order',
    ];

    /**
     * Отношение к определению термина
     */
    public function termDefinition()
    {
        return $this->belongsTo(TermDefinition::class);
    }

    /**
     * Получает полный URL изображения
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/'.$this->image_path);
    }

    /**
     * Получает alt текст или название термина по умолчанию
     */
    public function getAltTextAttribute($value): string
    {
        if ($value) {
            return $value;
        }

        return $this->termDefinition?->term?->name ?? 'Изображение термина';
    }
}
