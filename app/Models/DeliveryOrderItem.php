<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOrderItem extends Model
{
    protected $fillable = [
        'delivery_order_id',
        'item_name',
        'description',
        'qty',
        'unit',
        'condition',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function deliveryOrder(): BelongsTo
    {
        return $this->belongsTo(DeliveryOrder::class);
    }
}