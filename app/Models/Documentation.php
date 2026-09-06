<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documentation extends Model
{
    protected $guarded = [];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
