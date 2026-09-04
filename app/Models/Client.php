<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'company_name',
        'contact_person',
        'phone',
        'email',
        'city',
        'status',
        'address',
        'notes',
    ];

    /**
     * Daftar quotation milik Client.
     */
    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    /**
     * Daftar Project milik Client.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}