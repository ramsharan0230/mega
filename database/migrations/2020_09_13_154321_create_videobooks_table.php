<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideobooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videobooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->comment('user_id => Student');
            $table->unsignedBigInteger('exhibitor_id')->nullable();
            $table->unsignedBigInteger('datetime_id')->nullable();
            $table->tinyInteger('isBooked')->default(0)->comment('0 => not booked | 1 => booked')->nullable();
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
        Schema::dropIfExists('videobooks');
    }
}
