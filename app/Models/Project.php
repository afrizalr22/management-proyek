<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'mandor_id',
        'project_code',
        'project_name',
        'location',
        'description',
        'contract_number',
        'contract_date',
        'project_budget',
        'contract_value',
        'start_date',
        'end_date',
        'progress',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'contract_date' => 'date',
            'start_date' => 'date',
            'end_date' => 'date',
            'project_budget' => 'decimal:2',
            'contract_value' => 'decimal:2',
            'progress' => 'integer',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function mandor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'mandor_id'
        );
    }

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'project_workers',
            'project_id',
            'worker_id'
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

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function progresses(): HasMany
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

    public function quotations(): HasMany
    {
        return $this->hasMany(
            Quotation::class
        );
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(
            Invoice::class
        );
    }

    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(
            DeliveryOrder::class
        );
    }

    public function workerAssignments(): HasMany
    {
        return $this->hasMany(
            ProjectWorker::class
        );
    }
}