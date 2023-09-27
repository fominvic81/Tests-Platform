<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    public $fillable = [
        'type',
        'text',
        'data',
        'points',
        'test_id',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public $casts = [
        'type' => QuestionType::class,
        'data' => 'json',
    ];
}
