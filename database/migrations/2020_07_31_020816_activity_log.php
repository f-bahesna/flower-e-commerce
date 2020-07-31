<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activitys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_user');
            $table->string('id_product');
            $table->string('pesan_log');
            $table->string('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activitys');
    }
}
