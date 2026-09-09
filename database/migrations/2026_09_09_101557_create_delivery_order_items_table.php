<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Database lama sudah mempunyai tabel ini.
         * Database baru dan database testing akan
         * membuatnya melalui migration ini.
         */
        if (
            Schema::hasTable(
                'delivery_order_items'
            )
        ) {
            return;
        }

        Schema::create(
            'delivery_order_items',
            function (Blueprint $table): void {
                $table->id();

                $table->foreignId(
                    'delivery_order_id'
                )
                    ->constrained(
                        'delivery_orders'
                    )
                    ->cascadeOnDelete();

                $table->string('item_name');

                $table->text('description')
                    ->nullable();

                $table->decimal(
                    'qty',
                    10,
                    2
                );

                $table->string('unit', 50);

                $table->string(
                    'condition',
                    30
                )->default('good');

                $table->unsignedInteger(
                    'sort_order'
                )->default(0);

                $table->timestamps();

                $table->index([
                    'delivery_order_id',
                    'sort_order',
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'delivery_order_items'
        );
    }
};