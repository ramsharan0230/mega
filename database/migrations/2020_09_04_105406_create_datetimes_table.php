<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatetimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datetimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exhibitor_id')->nullable();
            $table->foreign('exhibitor_id')->references('id')->on('exhibitors')->onDelete('cascade');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->tinyInteger('publish')->default(1)->nullable();
            $table->tinyInteger('isAvailable')->default(1)->nullable()->comment('0 => unavailable | 1 => available');
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
        Schema::dropIfExists('datetimes');
    }
}
