<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_manual', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor_telepon',20)->unique();
            $table->string('address',100);
            $table->string('province');
            $table->string('city');
            $table->string('courier');
            $table->string('courier_service');
            $table->integer('product_id');
            $table->integer('qty');
            $table->integer('total_price');
            $table->enum('status',['verification','packing','shipping','done'])->nullable();
            $table->string('notes',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_manual');
    }
}
