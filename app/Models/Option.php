<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mews\Purifier\Casts\CleanHtml;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'text',
        'image',
        'correct',
        'group',
        'variant_id',
        'match_id',
        'sequence_index',
    ];

    protected $casts = [
        'text'=> CleanHtml::class,
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

}
