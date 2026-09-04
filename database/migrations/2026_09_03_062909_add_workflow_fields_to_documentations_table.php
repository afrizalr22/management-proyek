<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documentations', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Hubungan dengan Task
            |--------------------------------------------------------------------------
            */

            $table->foreignId('task_id')
                ->nullable()
                ->after('project_id')
                ->constrained('tasks')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Hubungan dengan laporan
            |--------------------------------------------------------------------------
            */

            $table->foreignId('daily_report_id')
                ->nullable()
                ->after('task_id')
                ->constrained('daily_reports')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informasi dokumentasi
            |--------------------------------------------------------------------------
            */

            $table->string('title')
                ->nullable()
                ->after('user_id');

            $table->enum('category', [
                'progress',
                'material',
                'safety',
                'obstacle',
                'other',
            ])
                ->default('progress')
                ->after('title');

            /*
            |--------------------------------------------------------------------------
            | Metadata file
            |--------------------------------------------------------------------------
            */

            $table->string('original_name')
                ->nullable()
                ->after('photo');

            $table->string('mime_type', 100)
                ->nullable()
                ->after('original_name');

            $table->unsignedBigInteger('file_size')
                ->nullable()
                ->after('mime_type');

            /*
            |--------------------------------------------------------------------------
            | Waktu pengambilan foto
            |--------------------------------------------------------------------------
            */

            $table->dateTime('taken_at')
                ->nullable()
                ->after('documentation_date');

            /*
            |--------------------------------------------------------------------------
            | Index pencarian
            |--------------------------------------------------------------------------
            */

            $table->index([
                'project_id',
                'category',
            ]);

            $table->index([
                'task_id',
                'category',
            ]);

            $table->index([
                'daily_report_id',
                'category',
            ]);

            $table->index([
                'user_id',
                'documentation_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('documentations', function (Blueprint $table) {
            $table->dropIndex([
                'project_id',
                'category',
            ]);

            $table->dropIndex([
                'task_id',
                'category',
            ]);

            $table->dropIndex([
                'daily_report_id',
                'category',
            ]);

            $table->dropIndex([
                'user_id',
                'documentation_date',
            ]);

            $table->dropConstrainedForeignId('daily_report_id');
            $table->dropConstrainedForeignId('task_id');

            $table->dropColumn([
                'title',
                'category',
                'original_name',
                'mime_type',
                'file_size',
                'taken_at',
            ]);
        });
    }
};