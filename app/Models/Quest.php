<?php

namespace App\Models;

use App\Enums\QuestCondition;
use App\Enums\QuestStatus;
use App\Observers\QuestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([QuestObserver::class])]
class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'image',
        'condition',
        'deadline',
        'value',
        'description',
        'xp',
        'parent_id',
        'user_id',
        'completed_at',
        'is_public',
    ];

    protected $dates = [
        'completed_at',
        'deadline',
    ];

    protected $guarded = ['is_rewarded'];

    protected $casts = [
        'status' => QuestStatus::class,
        'condition' => QuestCondition::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('customer', function (Builder $query) {
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function characteristics(): BelongsToMany
    {
        return $this->belongsToMany(Characteristic::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Quest::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Quest::class, 'parent_id');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(TimeProgress::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(Value::class, 'quest_id');
    }
}
