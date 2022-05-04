<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ammenity_id');
            $table->string('purpose');
            $table->text('description');
            $table->unsignedBigInteger('booked_by');
            $table->date('booking_date');
            $table->time('timeslots_start');
            $table->time('timeslots_end');
            $table->decimal('booking_price', 10, 2);
            $table->enum('payment_mode', ['cash', 'card', 'online'])->default('card');
            $table->dateTime('payment_date')->nullable();
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
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
        Schema::dropIfExists('reservations');
    }
}
