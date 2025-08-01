<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PracticeBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'subsection_id',
        'level',
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
}
