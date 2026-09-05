<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    protected $fillable = [
        'client_id',
        'project_id',
        'created_by',
        'quotation_number',
        'quotation_date',
        'valid_until',
        'client_name',
        'client_contact_person',
        'client_phone',
        'client_email',
        'client_address',
        'project_name',
        'project_location',
        'subtotal',
        'grand_total',
        'status',
        'notes',
        'sent_at',
        'approved_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'quotation_date' => 'date',
            'valid_until' => 'date',
            'subtotal' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'sent_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }
}