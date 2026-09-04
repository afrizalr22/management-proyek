<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyReport extends Model
{
    protected $fillable = [
        'report_number',
        'project_id',
        'task_id',
        'user_id',
        'report_date',
        'reported_progress',
        'work_status',
        'activities',
        'obstacles',
        'notes',
        'status',
        'submitted_at',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
            'reported_progress' => 'integer',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Pekerja yang membuat laporan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mandor yang memeriksa laporan.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function documentations(): HasMany
    {
        return $this->hasMany(Documentation::class);
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, [
            'draft',
            'revision',
        ], true);
    }

    public function canBeSubmitted(): bool
    {
        return in_array($this->status, [
            'draft',
            'revision',
        ], true);
    }

    public function canBeReviewed(): bool
    {
        return $this->status === 'submitted';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}