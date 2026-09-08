<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (
            Blueprint $table
        ): void {
            $table->id();

            /*
             * Invoice dapat dibuat sebelum Project.
             * Jika Project dihapus, Invoice tetap disimpan.
             */
            $table
                ->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
             * Satu Quotation hanya menghasilkan satu Invoice.
             */
            $table->foreignId('quotation_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
             * Pembuat Invoice.
             */
            $table
                ->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table
                ->string('invoice_number', 100)
                ->unique();

            $table->date('invoice_date');

            $table
                ->date('due_date')
                ->nullable();

            $table
                ->enum('status', [
                    'draft',
                    'issued',
                    'sent',
                    'cancelled',
                ])
                ->default('draft');

            /*
             * Snapshot Client.
             */
            $table->string('client_name');

            $table
                ->string('client_contact_person')
                ->nullable();

            $table
                ->string('client_phone', 20)
                ->nullable();

            $table
                ->string('client_email')
                ->nullable();

            $table
                ->text('client_address')
                ->nullable();

            /*
             * Nilai Invoice.
             */
            $table
                ->decimal('subtotal', 15, 2)
                ->default(0);

            $table
                ->decimal('tax_amount', 15, 2)
                ->default(0);

            $table
                ->decimal('discount_amount', 15, 2)
                ->default(0);

            $table
                ->decimal('grand_total', 15, 2)
                ->default(0);

            $table
                ->decimal('paid_amount', 15, 2)
                ->default(0);

            $table
                ->enum('payment_status', [
                    'unpaid',
                    'partial',
                    'paid',
                ])
                ->default('unpaid');

            /*
             * Riwayat status.
             */
            $table
                ->timestamp('issued_at')
                ->nullable();

            $table
                ->timestamp('sent_at')
                ->nullable();

            $table
                ->timestamp('paid_at')
                ->nullable();

            $table
                ->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index([
                'project_id',
                'status',
            ]);

            $table->index([
                'payment_status',
                'due_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};