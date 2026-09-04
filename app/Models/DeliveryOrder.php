<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryOrder extends Model
{
    protected $fillable = [
        'project_id',
        'created_by',
        'delivery_number',
        'delivery_date',
        'destination',
        'receiver_name',
        'receiver_phone',
        'status',
        'sent_at',
        'received_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'delivery_date' => 'date',
            'sent_at' => 'datetime',
            'received_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(DeliveryOrderItem::class)
            ->orderBy('sort_order');
    }
}