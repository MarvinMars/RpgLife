<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const MAX_XP = 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guarded = ['level', 'xp'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }

    public function characteristics(): HasMany
    {
        return $this->hasMany(Characteristic::class);
    }

    public function addLevel(int $level = 1): int
    {
        $this->level += $level;

        $this->save();

        $this->refresh();

        return $this->level;
    }

    public function addXP(int $xp = 0): int
    {
        $this->xp += $xp;

        if ($this->xp >= self::MAX_XP) {
            $level = $this->calculateLevelFromXp($this->xp);

            $this->level += $level;

            $this->xp = $this->calculateXpAfterLevelUp($this->xp, $level);

        }

        $this->save();

        $this->refresh();

        return $this->xp;
    }

    public function calculateLevelFromXp(int $xp = 0): int
    {
        return floor($xp / self::MAX_XP);
    }

    public function calculateXpAfterLevelUp(int $xp = 0, int $level = 1): int
    {
        return $xp - floor($level * self::MAX_XP);
    }
}
