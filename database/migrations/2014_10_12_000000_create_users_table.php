<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('reg_code',100);
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('display_name',100);
            $table->string('email')->unique();
            $table->string('mobile_no',50);
            $table->string('landline_no',50);
            $table->longText('address');
            $table->string('zip',10);
            $table->string('profile_pic');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
