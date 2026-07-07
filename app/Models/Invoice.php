<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Invoice extends Model
{
    protected $guarded = [];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function items() : hasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
