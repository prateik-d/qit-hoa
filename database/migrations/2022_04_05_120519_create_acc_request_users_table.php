<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccRequestUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_request_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acc_request_id');
            $table->unsignedBigInteger('neighbour_id');
            $table->enum('approval_status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->text('neighbour_note')->nullable();
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
        Schema::dropIfExists('acc_request_users');
    }
}
