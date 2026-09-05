<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id',
        'item_name',
        'description',
        'qty',
        'unit',
        'price',
        'total',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'decimal:2',
            'price' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }
}