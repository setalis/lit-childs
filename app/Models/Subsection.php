<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subsection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'order',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function theoryBlock(): HasOne
    {
        return $this->hasOne(TheoryBlock::class);
    }

    public function practiceBlocks(): HasMany
    {
        return $this->hasMany(PracticeBlock::class)->orderBy('order');
    }

    public function homeworkBlock(): HasOne
    {
        return $this->hasOne(HomeworkBlock::class);
    }

    public function controlBlocks(): HasMany
    {
        return $this->hasMany(ControlBlock::class)->orderBy('order');
    }
}
