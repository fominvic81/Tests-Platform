<?php

namespace App\Models;

use App\Enums\Accessibility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mews\Purifier\Casts\CleanHtml;

class Course extends Model
{
    use HasFactory;

    public static function booted(): void
    {
        static::addGlobalScope('allowed', function (Builder $builder) {
            $builder->where('published', '=', true)->where('accessibility', '=', Accessibility::Public);
            $user = auth()->user();
            if ($user) $builder->orWhereBelongsTo($user);
        });
    }

    protected $fillable = [
        'name',
        'image',
        'description',
        'accessibility',
    ];

    protected $with = [
        'topics',
    ];

    protected $casts = [
        'description' => CleanHtml::class,
        'acessibility' => Accessibility::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tests(): HasMany
    {
        return $this->HasMany(Test::class);
    }

    public function topics(): HasMany
    {
        return $this->HasMany(Topic::class);
    }

    public function savedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_course_user');
    }
}
