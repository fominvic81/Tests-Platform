<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class TestingSessionSettings extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updated(function (TestingSessionSettings $settings) {
            $time = $settings->time ? strtotime($settings->time, 0) : null;
            $settings->sessions()->getQuery()->notEnded()->update([
                'ends_at' => $time ? DB::raw("SEC_TO_TIME(TIME_TO_SEC(`created_at`) + $time)") : null,
            ]);
        });
    }

    protected $fillable = [
        'time',
        'shuffle_questions',
        'shuffle_options',
        'show_result',
        'show_answers',
        'points_min',
        'points_max',
    ];

    public function sessions(): HasMany
    {
        return $this->hasMany(TestingSession::class);
    }

}
