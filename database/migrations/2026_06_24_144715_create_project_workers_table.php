<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_workers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();

            $table->foreignId('worker_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('assigned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->date('joined_at')
                ->nullable();

            $table->date('ended_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'project_id',
                'worker_id',
            ]);

            $table->index([
                'worker_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_workers');
    }
};