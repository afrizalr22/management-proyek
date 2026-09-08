<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable([
    'name',
    'email',
    'phone',
    'photo',
    'status',
    'password',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Membatasi query hanya untuk akun aktif.
     */
    public function scopeActive(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'active'
        );
    }

    /**
     * Menentukan apakah akun pengguna masih aktif.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Project yang dikelola User sebagai Mandor.
     */
    public function managedProjects(): HasMany
    {
        return $this->hasMany(
            Project::class,
            'mandor_id'
        );
    }

    /**
     * Seluruh Project yang pernah diikuti sebagai Pekerja.
     */
    public function workerProjects(): BelongsToMany
    {
        return $this->belongsToMany(
            Project::class,
            'project_workers',
            'worker_id',
            'project_id'
        )
            ->withPivot([
                'id',
                'assigned_by',
                'status',
                'joined_at',
                'ended_at',
            ])
            ->withTimestamps();
    }

    /**
     * Project yang sedang aktif diikuti sebagai Pekerja.
     */
    public function activeWorkerProjects(): BelongsToMany
    {
        return $this->workerProjects()
            ->wherePivot(
                'status',
                'active'
            );
    }

    /**
     * Detail seluruh penugasan Project milik Pekerja.
     */
    public function projectAssignments(): HasMany
    {
        return $this->hasMany(
            ProjectWorker::class,
            'worker_id'
        );
    }

    /**
     * Penugasan pekerja yang dibuat oleh User ini.
     */
    public function assignedProjectWorkers(): HasMany
    {
        return $this->hasMany(
            ProjectWorker::class,
            'assigned_by'
        );
    }

    public function projectProgress(): HasMany
    {
        return $this->hasMany(
            ProjectProgress::class
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