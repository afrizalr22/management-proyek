<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'delivery_orders',
            function (Blueprint $table): void {
                $table->dropForeign([
                    'project_id',
                ]);
            }
        );

        /*
         * Project yang sudah memiliki Surat Jalan
         * tidak boleh dihapus agar histori dokumen
         * pengiriman tetap tersimpan.
         */
        Schema::table(
            'delivery_orders',
            function (Blueprint $table): void {
                $table
                    ->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->restrictOnDelete();
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'delivery_orders',
            function (Blueprint $table): void {
                $table->dropForeign([
                    'project_id',
                ]);
            }
        );

        Schema::table(
            'delivery_orders',
            function (Blueprint $table): void {
                $table
                    ->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->cascadeOnDelete();
            }
        );
    }
};