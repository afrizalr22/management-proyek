<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documentation extends Model
{
    protected $fillable = [
        'project_id',
        'task_id',
        'daily_report_id',
        'user_id',
        'title',
        'category',
        'photo',
        'original_name',
        'mime_type',
        'file_size',
        'description',
        'documentation_date',
        'taken_at',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'documentation_date' => 'date',
            'taken_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(
            Project::class
        );
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(
            Task::class
        );
    }

    public function dailyReport(): BelongsTo
    {
        return $this->belongsTo(
            DailyReport::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }
}