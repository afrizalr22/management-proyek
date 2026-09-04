<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Client
            |--------------------------------------------------------------------------
            */

            $table->foreignId('client_id')
                ->constrained('clients')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Project hasil konversi quotation
            |--------------------------------------------------------------------------
            */

            $table->foreignId('project_id')
                ->nullable()
                ->unique()
                ->constrained('projects')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Owner pembuat quotation
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informasi quotation
            |--------------------------------------------------------------------------
            */

            $table->string('quotation_number', 100)
                ->unique();

            $table->date('quotation_date');

            $table->date('valid_until')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Snapshot data Client
            |--------------------------------------------------------------------------
            |
            | Data Client tetap disimpan agar quotation lama tidak berubah apabila
            | profil Client diperbarui.
            |
            */

            $table->string('client_name');

            $table->string('client_contact_person')
                ->nullable();

            $table->string('client_phone', 20)
                ->nullable();

            $table->string('client_email')
                ->nullable();

            $table->text('client_address')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Rencana Project
            |--------------------------------------------------------------------------
            */

            $table->string('project_name');

            $table->text('project_location')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Nilai quotation
            |--------------------------------------------------------------------------
            */

            $table->decimal('subtotal', 15, 2)
                ->default(0);

            $table->decimal('grand_total', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Status quotation
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'sent',
                'approved',
                'rejected',
                'expired',
            ])->default('draft');

            $table->dateTime('sent_at')
                ->nullable();

            $table->dateTime('approved_at')
                ->nullable();

            $table->dateTime('rejected_at')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index([
                'client_id',
                'status',
            ]);

            $table->index([
                'quotation_date',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};