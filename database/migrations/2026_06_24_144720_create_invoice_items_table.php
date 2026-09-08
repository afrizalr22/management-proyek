<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (
            Blueprint $table
        ): void {
            $table->id();

            $table
                ->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('item_name');

            $table
                ->text('description')
                ->nullable();

            $table->decimal('qty', 10, 2);

            $table->string('unit', 50);

            $table->decimal('price', 15, 2);

            $table->decimal('total', 15, 2);

            $table
                ->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->index([
                'invoice_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};