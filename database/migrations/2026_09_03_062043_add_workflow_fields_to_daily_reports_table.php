<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Identitas laporan
            |--------------------------------------------------------------------------
            */

            $table->string('report_number', 50)
                ->nullable()
                ->unique()
                ->after('id');

            /*
            |--------------------------------------------------------------------------
            | Task yang dilaporkan
            |--------------------------------------------------------------------------
            */

            $table->foreignId('task_id')
                ->nullable()
                ->after('project_id')
                ->constrained('tasks')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Progress yang dilaporkan Pekerja
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('reported_progress')
                ->default(0)
                ->after('report_date');

            $table->enum('work_status', [
                'in_progress',
                'completed',
            ])
                ->default('in_progress')
                ->after('reported_progress');

            /*
            |--------------------------------------------------------------------------
            | Status validasi laporan
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'submitted',
                'revision',
                'approved',
            ])
                ->default('draft')
                ->after('notes');

            $table->dateTime('submitted_at')
                ->nullable()
                ->after('status');

            /*
            |--------------------------------------------------------------------------
            | Pemeriksaan Mandor
            |--------------------------------------------------------------------------
            */

            $table->foreignId('reviewed_by')
                ->nullable()
                ->after('submitted_at')
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('reviewed_at')
                ->nullable()
                ->after('reviewed_by');

            $table->text('review_notes')
                ->nullable()
                ->after('reviewed_at');

            $table->index([
                'project_id',
                'status',
            ]);

            $table->index([
                'task_id',
                'status',
            ]);

            $table->index([
                'user_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->dropIndex([
                'project_id',
                'status',
            ]);

            $table->dropIndex([
                'task_id',
                'status',
            ]);

            $table->dropIndex([
                'user_id',
                'status',
            ]);

            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropConstrainedForeignId('task_id');

            $table->dropColumn([
                'report_number',
                'reported_progress',
                'work_status',
                'status',
                'submitted_at',
                'reviewed_at',
                'review_notes',
            ]);
        });
    }
};