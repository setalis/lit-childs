<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'type',
        'text',
        'order',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class, 'question_id');
    }

    public function matchPairs(): HasMany
    {
        return $this->hasMany(TestMatchPair::class, 'question_id');
    }

    /**
     * Получить украинское название типа вопроса
     */
    public function getTypeDisplayAttribute(): string
    {
        $typeNames = [
            'single_choice' => 'Одиночний вибір',
            'multiple_choice' => 'Множинний вибір', 
            'fill_in_the_blank' => 'Заповнення пропусків',
            'matching' => 'Співставлення'
        ];

        return $typeNames[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }
} 