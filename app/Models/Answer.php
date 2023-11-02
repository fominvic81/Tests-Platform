<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_correct',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
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
