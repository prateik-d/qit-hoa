<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLostItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('found_by');
            $table->unsignedBigInteger('belongs_to');
            $table->text('description');
            $table->date('date_found');
            $table->string('location');
            $table->string('photo');
            $table->string('status',50);
            $table->date('date_claimed');
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
        Schema::dropIfExists('lost_items');
    }
}
