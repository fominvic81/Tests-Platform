<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'begin_at',
        'end_at',
    ];

    protected $casts = [
        'begin_at' => 'datetime',
        'end_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function settings(): BelongsTo
    {
        return $this->belongsTo(TestingSessionSettings::class, 'testing_session_settings_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(TestingSession::class);
    }
}
