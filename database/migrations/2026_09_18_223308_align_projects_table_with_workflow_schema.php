<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Lepaskan foreign key lama agar aturan penghapusan
         * Client dan Mandor dapat diselaraskan.
         */
        Schema::table('projects', function (
            Blueprint $table
        ): void {
            $table->dropForeign([
                'client_id',
            ]);

            $table->dropForeign([
                'mandor_id',
            ]);
        });

        /*
         * Mandor dapat tidak tersedia lagi tanpa menghapus
         * histori Project.
         */
        Schema::table('projects', function (
            Blueprint $table
        ): void {
            $table
                ->unsignedBigInteger('mandor_id')
                ->nullable()
                ->change();
        });

        /*
         * Client tidak boleh dihapus selama masih memiliki
         * Project. Jika Mandor dihapus, referensinya menjadi null.
         */
        Schema::table('projects', function (
            Blueprint $table
        ): void {
            $table
                ->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->restrictOnDelete();

            $table
                ->foreign('mandor_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });

        /*
         * Indeks digunakan oleh halaman daftar, filter,
         * dashboard, dan monitoring Project.
         */
        if (
            !Schema::hasIndex(
                'projects',
                [
                    'status',
                ]
            )
        ) {
            Schema::table('projects', function (
                Blueprint $table
            ): void {
                $table->index(
                    'status',
                    'projects_status_index'
                );
            });
        }

        if (
            !Schema::hasIndex(
                'projects',
                [
                    'client_id',
                    'status',
                ]
            )
        ) {
            Schema::table('projects', function (
                Blueprint $table
            ): void {
                $table->index(
                    [
                        'client_id',
                        'status',
                    ],
                    'projects_client_id_status_index'
                );
            });
        }

        if (
            !Schema::hasIndex(
                'projects',
                [
                    'mandor_id',
                    'status',
                ]
            )
        ) {
            Schema::table('projects', function (
                Blueprint $table
            ): void {
                $table->index(
                    [
                        'mandor_id',
                        'status',
                    ],
                    'projects_mandor_id_status_index'
                );
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasIndex(
                'projects',
                [
                    'mandor_id',
                    'status',
                ]
            )
        ) {
            Schema::table('projects', function (
                Blueprint $table
            ): void {
                $table->dropIndex(
                    'projects_mandor_id_status_index'
                );
            });
        }

        if (
            Schema::hasIndex(
                'projects',
                [
                    'client_id',
                    'status',
                ]
            )
        ) {
            Schema::table('projects', function (
                Blueprint $table
            ): void {
                $table->dropIndex(
                    'projects_client_id_status_index'
                );
            });
        }

        if (
            Schema::hasIndex(
                'projects',
                [
                    'status',
                ]
            )
        ) {
            Schema::table('projects', function (
                Blueprint $table
            ): void {
                $table->dropIndex(
                    'projects_status_index'
                );
            });
        }

        Schema::table('projects', function (
            Blueprint $table
        ): void {
            $table->dropForeign([
                'client_id',
            ]);

            $table->dropForeign([
                'mandor_id',
            ]);
        });

        /*
         * mandor_id hanya dapat dikembalikan menjadi wajib
         * apabila tidak terdapat Project tanpa Mandor.
         */
        $hasProjectWithoutMandor = DB::table('projects')
            ->whereNull('mandor_id')
            ->exists();

        if (!$hasProjectWithoutMandor) {
            Schema::table('projects', function (
                Blueprint $table
            ): void {
                $table
                    ->unsignedBigInteger('mandor_id')
                    ->nullable(false)
                    ->change();
            });
        }

        /*
         * Kembalikan aturan foreign key sesuai migration awal.
         */
        Schema::table('projects', function (
            Blueprint $table
        ): void {
            $table
                ->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->cascadeOnDelete();

            $table
                ->foreign('mandor_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
};