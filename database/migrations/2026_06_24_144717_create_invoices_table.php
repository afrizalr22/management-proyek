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
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();

            // Project
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            // Source quotation
            $table->foreignId('quotation_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Invoice information
            $table->string('invoice_number', 100)
                ->unique();

            $table->date('invoice_date');

            $table->date('due_date')
                ->nullable();

            // Invoice status
            $table->enum('status', [
                'draft',
                'issued',
                'sent',
                'cancelled',
            ])->default('draft');

            // Client snapshot
            $table->string('client_name');

            $table->string('client_contact_person')
                ->nullable();

            $table->string('client_phone', 20)
                ->nullable();

            $table->string('client_email')
                ->nullable();

            $table->text('client_address')
                ->nullable();

            // Financial
            $table->decimal('subtotal', 15, 2)
                ->default(0);

            $table->decimal('grand_total', 15, 2)
                ->default(0);

            // Payment
            $table->enum('payment_status', [
                'unpaid',
                'partial',
                'paid',
            ])->default('unpaid');

            // Additional information
            $table->text('notes')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};