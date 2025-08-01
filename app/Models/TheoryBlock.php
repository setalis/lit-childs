<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TheoryBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'subsection_id',
        // 'content', // Удаляем
    ];

    public function subsection(): BelongsTo
    {
        return $this->belongsTo(Subsection::class);
    }

    public function elements(): MorphMany
    {
        return $this->morphMany(BlockElement::class, 'block_elementable')->orderBy('order');
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
