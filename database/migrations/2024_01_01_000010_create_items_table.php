<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('species')->nullable(); // Pine, Beech, etc.
            $table->string('grade')->nullable(); // Quality grade
            $table->decimal('thickness', 8, 2)->nullable(); // in mm
            $table->decimal('width', 8, 2)->nullable(); // in mm
            $table->decimal('length', 8, 2)->nullable(); // in mm
            $table->string('unit')->default('piece'); // piece, m, m², m³
            $table->string('barcode')->nullable();
            $table->decimal('moisture_level', 5, 2)->nullable(); // percentage
            $table->decimal('low_stock_threshold', 10, 2)->default(0);
            $table->string('costing_method')->default('FIFO'); // FIFO, Average
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('items');
    }
}
