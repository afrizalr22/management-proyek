<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateQuotation = DB::table('invoices')
            ->whereNotNull('quotation_id')
            ->selectRaw('quotation_id, COUNT(*) as total')
            ->groupBy('quotation_id')
            ->havingRaw('COUNT(*) > 1')
            ->exists();

        if ($duplicateQuotation) {
            throw new \RuntimeException(
                'Tidak dapat membuat quotation_id unique karena terdapat Quotation dengan lebih dari satu Invoice.'
            );
        }

        /*
         * Lepaskan foreign key lama yang menggunakan
         * cascadeOnDelete.
         */
        Schema::table('invoices', function (
            Blueprint $table
        ): void {
            $table->dropForeign([
                'project_id',
            ]);
        });

        /*
         * Project dibuat opsional karena Invoice dapat
         * dibuat sebelum Project.
         */
        Schema::table('invoices', function (
            Blueprint $table
        ): void {
            $table
                ->unsignedBigInteger('project_id')
                ->nullable()
                ->change();
        });

        /*
         * Pasang kembali foreign key menggunakan
         * nullOnDelete agar histori Invoice dipertahankan.
         */
        Schema::table('invoices', function (
            Blueprint $table
        ): void {
            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->nullOnDelete();

            $table->unique(
                'quotation_id',
                'invoices_quotation_id_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (
            Blueprint $table
        ): void {
            $table->dropUnique(
                'invoices_quotation_id_unique'
            );

            $table->dropForeign([
                'project_id',
            ]);
        });

        /*
         * Kembalikan project_id menjadi wajib hanya jika
         * tidak ada Invoice tanpa Project.
         */
        $hasInvoiceWithoutProject = DB::table('invoices')
            ->whereNull('project_id')
            ->exists();

        if (!$hasInvoiceWithoutProject) {
            Schema::table('invoices', function (
                Blueprint $table
            ): void {
                $table
                    ->unsignedBigInteger('project_id')
                    ->nullable(false)
                    ->change();
            });
        }

        Schema::table('invoices', function (
            Blueprint $table
        ): void {
            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
        });
    }
};