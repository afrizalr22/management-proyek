<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\DailyReport;
use App\Models\Documentation;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function managedProjects() : HasMany
    {
        return $this->hasMany(Project::class, 'mandor_id');
    }

    public function workerProjects() : BelongsToMany
    {
        return $this->belongsToMany(
            Project::class,
            'project_workers',
            'worker_id',
            'project_id'
        );
    }

    public function projectProgress() : HasMany
    {
        return $this->hasMany(ProjectProgress::class);
    }

    public function dailyReports() : HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function documentations() : HasMany
    {
        return $this->hasMany(Documentation::class);
    }
}