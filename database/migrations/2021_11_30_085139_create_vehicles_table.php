<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->enum('owned_by', ['self', 'guest'])->default('self');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('relationship')->nullable();
            $table->unsignedBigInteger('vehicle_make_id');
            $table->unsignedBigInteger('vehicle_model_id');
            $table->unsignedBigInteger('vehicle_color_id');
            $table->string('license_plate_no');
            $table->string('toll_tag_no');
            $table->string('toll_tag_type');
            $table->enum('access_toll_tags_needed', ['yes', 'no'])->default('no');
            $table->enum('stickers_needed', ['yes', 'no'])->default('no');
            $table->date('application_date');
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
        Schema::dropIfExists('vehicles');
    }
}
