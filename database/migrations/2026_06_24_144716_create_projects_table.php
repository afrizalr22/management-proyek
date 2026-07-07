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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('mandor_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('project_code', 50)->unique();
            $table->string('project_name');
            $table->text('location')->nullable();
            $table->longText('description')->nullable();
            $table->string('contract_number', 100)->nullable();
            $table->date('contract_date')->nullable();
            $table->decimal('project_budget', 15, 2)->default(0);
            $table->decimal('contract_value', 15, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->enum('status', [
                'draft',
                'planning',
                'on_progress',
                'completed',
                'cancelled'
            ])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
