<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    public function scopeActive(Builder $query): void
    {
        $query->where('begin_at', '<', now())->where('end_at', '>', now());
    }

    public function scopeNotEnded(Builder $query): void
    {
        $query->where('end_at', '>', now());
    }

    protected $fillable = [
        'label',
        'begin_at',
        'end_at',
    ];

    protected $casts = [
        'begin_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function hasBegun(): bool
    {
        return $this->begin_at < now();
    }

    public function hasEnded(): bool
    {
        return $this->end_at < now();
    }

    public function isActive(): bool
    {
        return $this->begin_at < now() && $this->end_at > now();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class)->withoutGlobalScope('allowed');
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
