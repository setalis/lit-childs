<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        // 'first_letter' не нужно добавлять в fillable, так как это вычисляемое поле
    ];

    /**
     * Отношение к толкованиям термина
     */
    public function definitions()
    {
        return $this->hasMany(TermDefinition::class)->orderBy('sort_order');
    }

    /**
     * Получает первое толкование для обратной совместимости
     */
    public function getDefinitionAttribute()
    {
        return $this->definitions->first()?->definition ?? '';
    }

    /**
     * Получает все изображения термина (основное + дополнительные)
     */
    public function getAllImages()
    {
        $images = collect();

        // Добавляем основное изображение термина, если оно есть
        if ($this->image_path) {
            $images->push([
                'image_path' => $this->image_path,
                'alt_text' => $this->name,
                'is_main' => true,
                'sort_order' => 0,
            ]);
        }

        // Добавляем дополнительные изображения из определений
        foreach ($this->definitions as $definition) {
            foreach ($definition->images as $image) {
                $images->push([
                    'image_path' => $image->image_path,
                    'alt_text' => $image->alt_text,
                    'is_main' => false,
                    'sort_order' => $image->sort_order,
                    'definition_index' => $definition->sort_order,
                ]);
            }
        }

        return $images->sortBy('sort_order');
    }

    /**
     * Получает обработанное определение с автоматическими ссылками
     */
    public function getProcessedDefinitionAttribute(): string
    {
        if (function_exists('process_figure_links')) {
            return process_figure_links($this->definition, true);
        }

        return $this->definition;
    }
}
