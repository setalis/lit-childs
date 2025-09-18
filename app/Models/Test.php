<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order',
    ];



    public function questions(): HasMany
    {
        return $this->hasMany(TestQuestion::class);
    }

    public function controlBlocks(): HasMany
    {
        return $this->hasMany(ControlBlock::class);
    }

    /**
     * Получить типы вопросов в тесте
     */
    public function getQuestionTypesAttribute(): array
    {
        if ($this->questions->isEmpty()) {
            return [];
        }
        
        return $this->questions->pluck('type')->unique()->values()->toArray();
    }

    /**
     * Получить отображаемые названия типов вопросов
     */
    public function getQuestionTypesDisplayAttribute(): array
    {
        $questionTypes = $this->getQuestionTypesAttribute();
        
        if (empty($questionTypes)) {
            return [];
        }
        
        $typeNames = [
            'single_choice' => 'Одиночний вибір',
            'multiple_choice' => 'Множинний вибір', 
            'fill_in_the_blank' => 'Заповнення пропусків',
            'matching' => 'Співставлення'
        ];

        return collect($questionTypes)->map(function ($type) use ($typeNames) {
            return $typeNames[$type] ?? ucfirst(str_replace('_', ' ', $type));
        })->toArray();
    }
} 