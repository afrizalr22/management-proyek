<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasAssignedBy = Schema::hasColumn(
            'project_workers',
            'assigned_by'
        );

        $hasStatus = Schema::hasColumn(
            'project_workers',
            'status'
        );

        $hasJoinedAt = Schema::hasColumn(
            'project_workers',
            'joined_at'
        );

        $hasEndedAt = Schema::hasColumn(
            'project_workers',
            'ended_at'
        );

        $hasAssignedByForeign = collect(
            Schema::getForeignKeys(
                'project_workers'
            )
        )->contains(
            fn (array $foreign): bool =>
                $foreign['columns'] === [
                    'assigned_by',
                ]
        );

        Schema::table(
            'project_workers',
            function (Blueprint $table) use (
                $hasAssignedBy,
                $hasStatus,
                $hasJoinedAt,
                $hasEndedAt,
                $hasAssignedByForeign
            ): void {
                if (! $hasAssignedBy) {
                    $table->foreignId('assigned_by')
                        ->nullable()
                        ->after('worker_id')
                        ->constrained('users')
                        ->nullOnDelete();
                } elseif (! $hasAssignedByForeign) {
                    $table->foreign('assigned_by')
                        ->references('id')
                        ->on('users')
                        ->nullOnDelete();
                }

                if (! $hasStatus) {
                    $table->enum(
                        'status',
                        [
                            'active',
                            'inactive',
                        ]
                    )
                        ->default('active')
                        ->after('assigned_by');
                }

                if (! $hasJoinedAt) {
                    $table->date('joined_at')
                        ->nullable()
                        ->after('status');
                }

                if (! $hasEndedAt) {
                    $table->date('ended_at')
                        ->nullable()
                        ->after('joined_at');
                }
            }
        );

        if (
            ! Schema::hasIndex(
                'project_workers',
                [
                    'worker_id',
                    'status',
                ]
            )
        ) {
            Schema::table(
                'project_workers',
                function (Blueprint $table): void {
                    $table->index([
                        'worker_id',
                        'status',
                    ]);
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (
            Schema::hasIndex(
                'project_workers',
                [
                    'worker_id',
                    'status',
                ]
            )
        ) {
            Schema::table(
                'project_workers',
                function (Blueprint $table): void {
                    $table->dropIndex([
                        'worker_id',
                        'status',
                    ]);
                }
            );
        }

        $hasAssignedByForeign = collect(
            Schema::getForeignKeys(
                'project_workers'
            )
        )->contains(
            fn (array $foreign): bool =>
                $foreign['columns'] === [
                    'assigned_by',
                ]
        );

        if ($hasAssignedByForeign) {
            Schema::table(
                'project_workers',
                function (Blueprint $table): void {
                    $table->dropForeign([
                        'assigned_by',
                    ]);
                }
            );
        }

        $columns = collect([
            'assigned_by',
            'status',
            'joined_at',
            'ended_at',
        ])->filter(
            fn (string $column): bool =>
                Schema::hasColumn(
                    'project_workers',
                    $column
                )
        )->values()->all();

        if ($columns !== []) {
            Schema::table(
                'project_workers',
                function (Blueprint $table) use (
                    $columns
                ): void {
                    $table->dropColumn($columns);
                }
            );
        }
    }
};