<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('role')->nullable();
            $table->string('redirect_to')->nullable();
            $table->string('type')->nullable();
            $table->string('activation_link')->nullable();
            $table->text('access_level')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('mobile')->nullable();
            $table->string('otp')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country')->nullable();
            $table->string('academic_qualification')->nullable();
            $table->string('gpa')->nullable();
            $table->string('passed_year')->nullable();
            $table->string('interested_course')->nullable();
            $table->string('interested_country')->nullable();
            $table->string('proficiency_test')->nullable();
            $table->string('know_about')->nullable();
            $table->tinyInteger('publish')->default(1)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
