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
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('invoice_number', 100)->unique();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('client_name');
            $table->string('client_contact_person');
            $table->string('client_phone', 20)->nullable();
            $table->string('client_email')->nullable();
            $table->text('client_address')->nullable();
            $table->decimal('total', 15, 2);
            $table->enum('payment_status', [
                'unpaid',
                'partial',
                'paid'
            ])->default('unpaid');
            $table->text('notes')->nullable();
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
