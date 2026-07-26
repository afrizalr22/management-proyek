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
       Schema::create('quotations', function (Blueprint $table) {

            $table->id();
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('quotation_number', 100)->unique();
            $table->date('quotation_date');
            $table->date('valid_until')->nullable();
            $table->string('client_name');
            $table->string('client_contact_person');
            $table->string('client_phone', 20)->nullable();
            $table->string('client_email')->nullable();
            $table->text('client_address')->nullable();
            $table->string('project_name');
            $table->string('project_location')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('grand_total', 15, 2);
            $table->enum('status', [
                'draft',
                'sent',
                'approved',
                'rejected',
                'expired',
            ])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
