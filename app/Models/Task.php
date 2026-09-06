<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'mandor_id',
        'worker_id',
        'task_code',
        'title',
        'description',
        'location',
        'priority',
        'status',
        'start_at',
        'due_at',
        'started_at',
        'submitted_at',
        'completed_at',
        'progress',
        'weight',
        'mandor_notes',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'due_at' => 'datetime',
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'completed_at' => 'datetime',
            'progress' => 'integer',
            'weight' => 'decimal:2',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function mandor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'mandor_id'
        );
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'worker_id'
        );
    }

    public function dailyReports(): HasMany
    {
        return $this->hasMany(
            DailyReport::class
        );
    }

    public function documentations(): HasMany
    {
        return $this->hasMany(
            Documentation::class
        );
    }
}