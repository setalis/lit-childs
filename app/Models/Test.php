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
} 