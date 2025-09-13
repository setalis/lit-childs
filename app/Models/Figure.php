<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'biography',
        'sources',
        'biography_2',
        'sources_2',
        'image_path',
        // 'first_letter' не нужно добавлять в fillable, так как это вычисляемое поле
    ];

    /**
     * Отношение к блокам
     */
    public function blocks()
    {
        return $this->hasMany(FigureBlock::class)->orderBy('order');
    }

    /**
     * Получить блоки биографии
     */
    public function biographyBlocks()
    {
        return $this->hasMany(FigureBlock::class)->where('type', 'biography')->orderBy('order');
    }

    /**
     * Получить блоки источников
     */
    public function sourceBlocks()
    {
        return $this->hasMany(FigureBlock::class)->where('type', 'sources')->orderBy('order');
    }

    /**
     * Получает полное имя персоналии
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Получает отображаемое имя (для обратной совместимости)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->full_name;
    }

    /**
     * Получает первую букву фамилии
     */
    public function getFirstLetterAttribute(): string
    {
        if ($this->last_name) {
            return mb_strtoupper(mb_substr($this->last_name, 0, 1, 'UTF-8'), 'UTF-8');
        }
        return '';
    }

    /**
     * Обновляет поле first_letter для всех записей
     */
    public static function updateFirstLetters(): void
    {
        $figures = self::all();
        
        foreach ($figures as $figure) {
            if ($figure->last_name) {
                $firstLetter = mb_strtoupper(mb_substr($figure->last_name, 0, 1, 'UTF-8'), 'UTF-8');
                
                // Обновляем через raw SQL, так как это виртуальное поле
                \DB::statement("UPDATE figures SET first_letter = ? WHERE id = ?", [$firstLetter, $figure->id]);
            }
        }
    }
}
