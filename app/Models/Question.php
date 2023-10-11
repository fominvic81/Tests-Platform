<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'text',
        'image',
        'points',
        'explanation',
        'test_id',
        'register_matters',
        'whitespace_matters',
        'show_amount_of_correct',
    ];

    protected $hidden = [
        'test_id',
    ];

    protected $with = [
        'topics',
        'options',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public $casts = [
        'type' => QuestionType::class,
        'register_matters' => 'boolean',
        'whitespace_matters' => 'boolean',
        'show_amount_of_correct' => 'boolean',
    ];
}
