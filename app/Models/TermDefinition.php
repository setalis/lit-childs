<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermDefinition extends Model
{
    use HasFactory;

    protected $fillable = [
        'term_id',
        'definition',
        'source',
        'sort_order',
    ];

    /**
     * Отношение к термину
     */
    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Отношение к изображениям
     */
    public function images()
    {
        return $this->hasMany(TermImage::class)->orderBy('sort_order');
    }

    /**
     * Получает обработанное определение с автоматическими ссылками
     */
    public function getProcessedDefinitionAttribute(): string
    {
        if (function_exists('process_figure_links')) {
            return process_figure_links($this->definition);
        }

        return $this->definition;
    }
}
