<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'definition',
        'image_path',
        // 'first_letter' не нужно добавлять в fillable, так как это вычисляемое поле
    ];

    /**
     * Получает обработанное определение с автоматическими ссылками
     *
     * @return string
     */
    public function getProcessedDefinitionAttribute(): string
    {
        if (function_exists('process_figure_links')) {
            return process_figure_links($this->definition);
        }
        
        return $this->definition;
    }
}
