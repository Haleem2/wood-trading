<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('lot_no');
            $table->decimal('qty_on_hand', 10, 2)->default(0);
            $table->decimal('qty_reserved', 10, 2)->default(0);
            $table->decimal('qty_available', 10, 2)->default(0);
            $table->decimal('cost', 15, 2)->default(0);
            $table->timestamp('received_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['item_id', 'warehouse_id']);
            $table->index(['lot_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_lots');
    }
}
