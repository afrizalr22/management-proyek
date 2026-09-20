<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            ! Schema::hasTable('invoices')
            || ! Schema::hasColumn(
                'invoices',
                'payment_status'
            )
        ) {
            return;
        }

        /*
         * Status overdue adalah kondisi turunan dari
         * due_date dan sisa tagihan, bukan status
         * pembayaran yang disimpan.
         */
        DB::table('invoices')
            ->where('payment_status', 'overdue')
            ->where('paid_amount', '<=', 0)
            ->update([
                'payment_status' => 'unpaid',
            ]);

        DB::table('invoices')
            ->where('payment_status', 'overdue')
            ->where('paid_amount', '>', 0)
            ->whereColumn(
                'paid_amount',
                '<',
                'grand_total'
            )
            ->update([
                'payment_status' => 'partial',
            ]);

        DB::table('invoices')
            ->where('payment_status', 'overdue')
            ->whereColumn(
                'paid_amount',
                '>=',
                'grand_total'
            )
            ->update([
                'payment_status' => 'paid',
            ]);

        /*
         * SQLite tidak mendukung MODIFY ENUM.
         * Migrasi pengujian tetap aman karena schema
         * awal sudah menggunakan tiga status ini.
         */
        if (
            DB::connection()->getDriverName()
            !== 'mysql'
        ) {
            return;
        }

        DB::statement(
            "ALTER TABLE invoices
            MODIFY payment_status
            ENUM('unpaid', 'partial', 'paid')
            NOT NULL DEFAULT 'unpaid'"
        );
    }

    public function down(): void
    {
        if (
            ! Schema::hasTable('invoices')
            || ! Schema::hasColumn(
                'invoices',
                'payment_status'
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
            "ALTER TABLE invoices
            MODIFY payment_status
            ENUM('unpaid', 'partial', 'paid', 'overdue')
            NOT NULL DEFAULT 'unpaid'"
        );
    }
};