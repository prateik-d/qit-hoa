<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_title',100);
            $table->unsignedBigInteger('event_category_id');
            $table->text('event_description');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('contact_phone',100);
            $table->string('contact_email',100);
            $table->unsignedBigInteger('event_location_id');
            $table->string('fb_url');
            $table->string('twitter_url');
            $table->string('no_of_rsvp');
            $table->unsignedBigInteger('organized_by');
            $table->enum('status', ['pending', 'cancelled', 'completed', 'archived'])->default('pending');
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
        Schema::dropIfExists('events');
    }
}
