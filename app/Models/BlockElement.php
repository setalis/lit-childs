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
     */
    public function getProcessedContentAttribute(): string
    {
        $context = $this->isFromControlBlock() ? 'control_block' : null;

        // Используем прямой вызов сервиса, так как хелпер может зависать
        $service = app(\App\Services\FigureLinkService::class);

        return $service->processHtml($this->content ?? '', $context);
    }

    /**
     * Получает ключевые слова с обработанными ссылками на термины
     */
    public function getProcessedKeywordsAttribute(): ?array
    {
        if ($this->element_type !== 'keywords') {
            return null;
        }

        // Декодируем JSON для ключевых слов
        $keywords = json_decode($this->content, true);
        if (! is_array($keywords)) {
            return null;
        }

        $context = $this->isFromControlBlock() ? 'control_block' : null;
        $service = app(\App\Services\FigureLinkService::class);

        return array_map(function ($keyword) use ($service, $context) {
            return $service->processHtml($keyword, $context);
        }, $keywords);
    }

    /**
     * Проверяет, принадлежит ли элемент к контрольному блоку или блоку домашних заданий
     */
    public function isFromControlBlock(): bool
    {
        return in_array($this->block_elementable_type, [
            'App\Models\ControlBlock',
            'App\Models\HomeworkBlock'
        ]);
    }
}
