<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
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
    'password',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Project yang dikelola sebagai Mandor.
     */
    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'mandor_id');
    }

    /**
     * Project yang diikuti sebagai Pekerja.
     */
    public function workerProjects(): BelongsToMany
    {
        return $this->belongsToMany(
            Project::class,
            'project_workers',
            'worker_id',
            'project_id'
        )->withTimestamps();
    }

    public function projectWorkerAssignments(): HasMany
    {
        return $this->hasMany(ProjectWorker::class, 'worker_id');
    }

    public function projectProgresses(): HasMany
    {
        return $this->hasMany(ProjectProgress::class);
    }

    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function documentations(): HasMany
    {
        return $this->hasMany(Documentation::class);
    }

    /**
     * Task yang dibuat oleh Mandor.
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'mandor_id');
    }

    /**
     * Task yang diberikan kepada Pekerja.
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'worker_id');
    }

    /**
     * Quotation yang dibuat oleh Owner.
     */
    public function createdQuotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'created_by');
    }

    /**
     * Laporan yang diperiksa oleh Mandor.
     */
    public function reviewedDailyReports(): HasMany
    {
        return $this->hasMany(
            DailyReport::class,
            'reviewed_by'
        );
    }

    public function createdInvoices(): HasMany
    {
        return $this->hasMany(
            Invoice::class,
            'created_by'
        );
    }

    public function createdDeliveryOrders(): HasMany
    {
        return $this->hasMany(
            DeliveryOrder::class,
            'created_by'
        );
    }
}