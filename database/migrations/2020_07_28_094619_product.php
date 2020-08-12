<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_product');
            $table->string('gambar_product');
            $table->string('jenis_product');
            $table->integer('umur_product');
            $table->string('harga_product');
            $table->string('stock_product');
            $table->string('berat_product');
            $table->longText('keterangan_product');
            $table->enum('status_product',['published','drafted']);
            $table->timestamp('created_at')->nullable();
            $table->string('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
