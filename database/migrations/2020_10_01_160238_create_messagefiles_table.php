<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagefilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messagefiles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('message_id')->nullable();
            $table->string('file_attachment')->nullable();

            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');

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
        Schema::dropIfExists('messagefiles');
    }
}
