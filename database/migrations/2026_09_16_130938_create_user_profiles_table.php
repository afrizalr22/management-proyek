<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel detail profil pengguna.
     */
    public function up(): void
    {
        Schema::create(
            'user_profiles',
            function (Blueprint $table): void {
                $table->id();

                $table->foreignId('user_id')
                    ->unique()
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string(
                    'specialization'
                )->nullable();

                $table->text(
                    'address'
                )->nullable();

                $table->timestamps();
            }
        );
    }

    /**
     * Menghapus tabel detail profil pengguna.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};