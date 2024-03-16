<?php

namespace App\Models;

use App\Enums\QuestStatus;
use App\Observers\QuestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function PHPUnit\Framework\isFalse;

#[ObservedBy([QuestObserver::class])]
class Quest extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
		'slug',
		'status',
		'status',
		'description',
		'xp',
	];

	protected $guarded = ['is_rewarded'];

	protected $casts = [
		'status' => QuestStatus::class,
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function canReward(): bool
	{
		return $this->status === QuestStatus::COMPLETED && !$this->is_rewarded;
	}

	public function reward(): bool
	{
		$this->user->addXP($this->xp);
		$this->is_rewarded = true;
		return $this->save();
	}
}
