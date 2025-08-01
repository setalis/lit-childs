<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ControlBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'subsection_id',
        'test_id',
        'type',
        'order',
    ];

    public function subsection(): BelongsTo
    {
        return $this->belongsTo(Subsection::class);
    }

    public function elements(): MorphMany
    {
        return $this->morphMany(BlockElement::class, 'block_elementable')->orderBy('order');
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Константи для типів контрольних блоків
     */
    const TYPE_TEST = 'test';
    const TYPE_QUESTIONS = 'questions';

    /**
     * Отримати відображуване ім'я типу блоку
     */
    public function getTypeDisplayAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_TEST => 'Тестові завдання',
            self::TYPE_QUESTIONS => 'Питання та завдання',
            default => ucfirst($this->type),
        };
    }

    /**
     * Перевірка чи є блок тестовим
     */
    public function isTestType(): bool
    {
        return $this->type === self::TYPE_TEST;
    }

    /**
     * Перевірка чи є блок з питаннями
     */
    public function isQuestionsType(): bool
    {
        return $this->type === self::TYPE_QUESTIONS;
    }
}
