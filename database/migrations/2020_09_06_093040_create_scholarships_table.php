<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScholarshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->string('logo')->nullable();
            $table->string('percent')->nullable();
            $table->tinyInteger('show_in_home')->default(1)->nullable();

            $table->unsignedBigInteger('exhibitor_id')->nullable();
            $table->foreign('exhibitor_id')->references('id')->on('exhibitors')->onDelete('cascade');

            $table->tinyInteger('publish')->default(1)->nullable();
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
        Schema::dropIfExists('scholarships');
    }
}
