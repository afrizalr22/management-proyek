<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel kontak darurat pengguna.
     */
    public function up(): void
    {
        Schema::create(
            'emergency_contacts',
            function (Blueprint $table): void {
                $table->id();

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('name');

                $table->string(
                    'relationship',
                    100
                );

                $table->string(
                    'phone',
                    20
                );

                $table->unsignedTinyInteger(
                    'priority'
                )->default(1);

                $table->timestamps();

                $table->unique([
                    'user_id',
                    'priority',
                ]);

                $table->index([
                    'user_id',
                    'name',
                ]);
            }
        );
    }

    /**
     * Menghapus tabel kontak darurat pengguna.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};