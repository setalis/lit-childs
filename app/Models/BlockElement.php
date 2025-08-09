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

    /**
     * Получает контент с обработанными ссылками на персоналии
     *
     * @return string
     */
    public function getProcessedContentAttribute(): string
    {
        return process_figure_links($this->content ?? '', true);
    }

    /**
     * Получает ключевые слова с обработанными ссылками на термины
     *
     * @return array|null
     */
    public function getProcessedKeywordsAttribute(): ?array
    {
        if ($this->element_type !== 'keywords') {
            return null;
        }

        // Декодируем JSON для ключевых слов
        $keywords = json_decode($this->content, true);
        if (!is_array($keywords)) {
            return null;
        }

        return array_map(function($keyword) {
            return process_figure_links($keyword, true);
        }, $keywords);
    }
}
