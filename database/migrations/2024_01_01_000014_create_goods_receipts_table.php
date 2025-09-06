<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->string('reference_no');
            $table->timestamp('received_at');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->decimal('transport_cost', 15, 2)->default(0);
            $table->decimal('customs_cost', 15, 2)->default(0);
            $table->decimal('handling_cost', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('received_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_receipts');
    }
}
