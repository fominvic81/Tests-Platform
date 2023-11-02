<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mews\Purifier\Casts\CleanHtml;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'text',
        'image',
        'points',
        'explanation',
        'data',
    ];

    protected $hidden = [
        'test_id',
    ];

    protected $with = [
        'topics',
    ];

    protected $casts = [
        'type' => QuestionType::class,
        'text'=> CleanHtml::class,
        'data' => 'json'
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
}
