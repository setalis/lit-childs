<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BlockElement extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_elementable_id',
        'block_elementable_type',
        'element_type',
        'content',
        'order',
    ];

    /**
     * Get the parent block_elementable model (TheoryBlock, PracticeBlock, etc.).
     */
    public function block_elementable(): MorphTo
    {
        return $this->morphTo();
    }

    // Можно добавить accessor для content, чтобы автоматически декодировать JSON, если нужно
    // public function getContentAttribute($value)
    // {
    //     if (in_array($this->element_type, ['keywords', 'image', 'gallery', 'button_group'])) {
    //         return json_decode($value, true);
    //     }
    //     return $value;
    // }

    /**
     * Get the displayable name for the element type.
     *
     * @return string
     */
    public function getElementTypeDisplayAttribute(): string
    {
        return match ($this->element_type) {
            'text' => 'Текст',
            'keywords' => 'Ключові слова',
            'list' => 'Список',
            'image' => 'Зображення',
            'gallery' => 'Галерея',
            'button_group' => 'Група кнопок',
            default => ucfirst($this->element_type),
        };
    }

    /**
     * Получает контент с обработанными ссылками на персоналии
     *
     * @return string
     */
    public function getProcessedContentAttribute(): string
    {
        return process_figure_links($this->content ?? '', true);
    }
}
