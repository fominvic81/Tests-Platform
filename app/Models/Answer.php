<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_correct',
        'type',
        'options',
        'texts',
        'question_id',
        'testing_session_id',
    ];

    protected $with = [
        
    ];

    protected $casts = [
        'type' => QuestionType::class,
        'options' => AsArrayObject::class,
        'texts' => AsArrayObject::class,
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(TestingSession::class, 'testing_session_id');
    }
}
