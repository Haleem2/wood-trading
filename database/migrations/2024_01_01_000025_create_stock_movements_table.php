<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->foreignId('stock_lot_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['purchase_receipt', 'sales_issue', 'adjustment', 'transfer', 'return']);
            $table->enum('movement', ['in', 'out']);
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->string('reference_type')->nullable(); // purchase_order, sales_order, etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['item_id', 'warehouse_id']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}
