<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel pekerjaan Project.
     */
    public function up(): void
    {
        Schema::create(
            'tasks',
            function (Blueprint $table): void {
                $table->id();

                $table->foreignId('project_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('mandor_id')
                    ->constrained('users')
                    ->restrictOnDelete();

                $table->foreignId('worker_id')
                    ->constrained('users')
                    ->restrictOnDelete();

                $table->string(
                    'task_code',
                    50
                )->unique();

                $table->string('title');

                $table->longText(
                    'description'
                )->nullable();

                $table->string(
                    'location'
                )->nullable();

                $table->enum(
                    'priority',
                    [
                        'low',
                        'medium',
                        'high',
                        'urgent',
                    ]
                )->default('medium');

                $table->enum(
                    'status',
                    [
                        'assigned',
                        'in_progress',
                        'submitted',
                        'revision',
                        'completed',
                        'cancelled',
                    ]
                )->default('assigned');

                $table->dateTime(
                    'start_at'
                )->nullable();

                $table->dateTime(
                    'due_at'
                )->nullable();

                $table->dateTime(
                    'started_at'
                )->nullable();

                $table->dateTime(
                    'submitted_at'
                )->nullable();

                $table->dateTime(
                    'completed_at'
                )->nullable();

                $table->unsignedTinyInteger(
                    'progress'
                )->default(0);

                $table->decimal(
                    'weight',
                    5,
                    2
                )->default(1);

                $table->text(
                    'mandor_notes'
                )->nullable();

                $table->timestamps();

                $table->index([
                    'project_id',
                    'status',
                ]);

                $table->index([
                    'mandor_id',
                    'status',
                ]);

                $table->index([
                    'worker_id',
                    'status',
                ]);
            }
        );
    }

    /**
     * Menghapus tabel pekerjaan Project.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};