<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_workers', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('task_id')
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->foreignId('worker_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            $table->unique(['task_id', 'worker_id']);
            $table->index(['worker_id', 'task_id']);
        });

        DB::table('tasks')
            ->select(['id', 'worker_id', 'created_at', 'updated_at'])
            ->whereNotNull('worker_id')
            ->chunkById(500, function ($tasks): void {
                $rows = [];

                foreach ($tasks as $task) {
                    $rows[] = [
                        'task_id' => $task->id,
                        'worker_id' => $task->worker_id,
                        'created_at' => $task->created_at ?? now(),
                        'updated_at' => $task->updated_at ?? now(),
                    ];
                }

                if ($rows !== []) {
                    DB::table('task_workers')->insert($rows);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_workers');
    }
};