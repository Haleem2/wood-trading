<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->string('dn_number')->unique();
            $table->foreignId('sales_order_id')->constrained()->onDelete('cascade');
            $table->timestamp('delivered_at');
            $table->string('vehicle')->nullable();
            $table->string('driver')->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('delivered_by')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('delivery_notes');
    }
}
