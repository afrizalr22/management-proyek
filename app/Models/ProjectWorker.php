<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectWorker extends Model
{
    protected $guarded = [];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function worker() : BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
