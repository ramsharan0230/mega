<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('view_count')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('download')->nullable();
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('exhibition_hall_image')->nullable();

            $table->longText('introduction')->nullable();
            $table->longText('about')->nullable();
            $table->longText('services')->nullable();
            $table->longText('courses_fees')->nullable();

            $table->string('email_link')->nullable();
            $table->string('messenger')->nullable();
            $table->string('viber')->nullable();
            $table->string('whatsapp')->nullable();

            $table->text('access_level')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();

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
        Schema::dropIfExists('exhibitors');
    }
}
