<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FigureBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'figure_id',
        'type',
        'content',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Отношение к персоналии
     */
    public function figure()
    {
        return $this->belongsTo(Figure::class);
    }

    /**
     * Получить типы блоков
     */
    public static function getTypes(): array
    {
        return [
            'biography' => 'Біографія',
            'sources' => 'Джерела',
        ];
    }

    /**
     * Получить название типа
     */
    public function getTypeNameAttribute(): string
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }
}
