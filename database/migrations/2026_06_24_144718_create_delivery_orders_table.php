<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained('projects')
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informasi Surat Jalan
            |--------------------------------------------------------------------------
            */

            $table->string('delivery_number', 100)
                ->unique();

            $table->date('delivery_date');

            $table->text('destination');

            $table->string('receiver_name')
                ->nullable();

            $table->string('receiver_phone', 20)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Pengiriman
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'sent',
                'received',
                'cancelled',
            ])->default('draft');

            $table->dateTime('sent_at')
                ->nullable();

            $table->dateTime('received_at')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index([
                'project_id',
                'status',
            ]);

            $table->index([
                'delivery_date',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};