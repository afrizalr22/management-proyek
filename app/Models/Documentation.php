<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
            'documentation_date' => 'date',
            'taken_at' => 'datetime',
            'file_size' => 'integer',
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

    public function dailyReport(): BelongsTo
    {
        return $this->belongsTo(DailyReport::class);
    }

    /**
     * Pekerja yang mengunggah dokumentasi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }

        return Storage::disk('public')->url($this->photo);
    }

    public function getFormattedFileSizeAttribute(): ?string
    {
        if (!$this->file_size) {
            return null;
        }

        if ($this->file_size >= 1024 * 1024) {
            return number_format(
                $this->file_size / (1024 * 1024),
                2
            ).' MB';
        }

        return number_format(
            $this->file_size / 1024,
            2
        ).' KB';
    }
}