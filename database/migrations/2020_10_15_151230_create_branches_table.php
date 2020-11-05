<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('exhibitor_id')->nullable();
            $table->foreign('exhibitor_id')->references('id')->on('exhibitors')->onDelete('cascade');

            $table->string('user_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
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
        Schema::dropIfExists('branches');
    }
}
