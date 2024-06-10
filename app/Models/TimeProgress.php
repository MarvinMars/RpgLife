<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeProgress extends Model
{
    use HasFactory;

    protected $table = 'quest_time_progresses';

    protected $fillable = [
        'started_at',
        'ended_at',
        'total_elapsed_time',
        'quest_id',
    ];

    protected $dates = [
        'started_at',
        'paused_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'paused_at' => 'datetime',
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
