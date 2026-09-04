<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('city', 100)
                ->nullable()
                ->after('email');

            $table->enum('status', [
                'active',
                'lead',
                'inactive',
            ])
                ->default('active')
                ->after('city');

            $table->index('status');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['city']);

            $table->dropColumn([
                'city',
                'status',
            ]);
        });
    }
};