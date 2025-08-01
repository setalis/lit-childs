<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'biography',
        'image_path',
        // 'first_letter' не нужно добавлять в fillable, так как это вычисляемое поле
    ];

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
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        if (!empty($this->first_name) && !empty($this->last_name)) {
            return $this->full_name;
        }
        
        return $this->name ?: $this->full_name;
    }
}
