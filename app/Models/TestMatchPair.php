<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestMatchPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'left_text',
        'right_text',
        'order',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(TestQuestion::class, 'question_id');
    }
} 