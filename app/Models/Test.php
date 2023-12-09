<?php

namespace App\Models;

use App\Enums\Accessibility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mews\Purifier\Casts\CleanHtml;

class Test extends Model
{
    use HasFactory, SoftDeletes;
 
    public static function booted(): void
    {
        static::addGlobalScope('allowed', function (Builder $builder) {
            $builder
                ->where('published', true)->where('accessibility', Accessibility::Public)
                ->where(function ($query) {
                    return $query
                        ->where('course_id', null)
                        ->orWhereRelation('course', 'accessibility', Accessibility::Public);
                });
            $user = auth()->user();
            if ($user) $builder->orWhereBelongsTo($user);
        });
    }

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'image',
        'description',
        'published',
        'accessibility',
    ];

    protected $hidden = [
        'subject_id',
        'grade_id',
        'user_id',
        'course_id',
    ];

    protected $with = [
        'subject',
        'grade',
    ];

    protected $casts = [
        'description' => CleanHtml::class,
        'acessibility' => Accessibility::class,
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function savedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_test_user');
    }
}
