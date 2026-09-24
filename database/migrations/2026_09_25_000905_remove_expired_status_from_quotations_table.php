<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menghapus status persisted "expired" dari Quotation.
     *
     * Kedaluwarsa merupakan kondisi turunan dari:
     * - status masih draft; dan
     * - valid_until sudah melewati tanggal hari ini.
     */
    public function up(): void
    {
        if (
            ! Schema::hasTable('quotations')
            || ! Schema::hasColumn(
                'quotations',
                'status'
            )
        ) {
            return;
        }

        /*
         * Normalisasi data legacy terlebih dahulu.
         * Quotation expired kembali menjadi draft,
         * sedangkan kondisi kedaluwarsa dihitung
         * berdasarkan valid_until di aplikasi.
         */
        DB::table('quotations')
            ->where('status', 'expired')
            ->update([
                'status' => 'draft',
            ]);

        /*
         * SQLite yang dipakai saat testing tidak
         * membutuhkan perubahan ENUM secara manual.
         */
        if (
            DB::connection()->getDriverName()
            !== 'mysql'
        ) {
            return;
        }

        DB::statement(
            "ALTER TABLE quotations
            MODIFY status
            ENUM(
                'draft',
                'sent',
                'approved',
                'rejected'
            )
            NOT NULL DEFAULT 'draft'"
        );
    }

    /**
     * Mengembalikan schema sebelumnya.
     */
    public function down(): void
    {
        if (
            ! Schema::hasTable('quotations')
            || ! Schema::hasColumn(
                'quotations',
                'status'
            )
        ) {
            return;
        }

        if (
            DB::connection()->getDriverName()
            !== 'mysql'
        ) {
            return;
        }

        DB::statement(
            "ALTER TABLE quotations
            MODIFY status
            ENUM(
                'draft',
                'sent',
                'approved',
                'rejected',
                'expired'
            )
            NOT NULL DEFAULT 'draft'"
        );
    }
};
