<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Project extends Model
{
    protected $guarded = [];

    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function mandor() : BelongsTo
    {
        return $this->belongsTo(User::class, 'mandor_id');
    }

    public function workers()
    {
        return $this->belongsToMany(
            User::class,
            'pekerja_workers',
            'project_id',
            'worker_id'
        );
    }

    public function progresses() : hasMany  
    {
        return $this->hasMany(ProjectProgress::class);
    }

    public function dailyReports() : hasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function documentations() : hasMany
    {
        return $this->hasMany(Documentation::class);
    }

    public function quotations() : hasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function invoices() : hasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function deliveryOrders() : hasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }

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
}
