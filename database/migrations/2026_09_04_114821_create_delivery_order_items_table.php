<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('delivery_order_id')
                ->constrained('delivery_orders')
                ->cascadeOnDelete();

            $table->string('item_name');

            $table->text('description')
                ->nullable();

            $table->decimal('qty', 10, 2)
                ->default(1);

            $table->string('unit', 50)
                ->default('unit');

            $table->enum('condition', [
                'good',
                'damaged',
            ])->default('good');

            $table->unsignedInteger('sort_order')
                ->default(1);

            $table->timestamps();

            $table->index([
                'delivery_order_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_order_items');
    }
};