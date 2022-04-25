<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLostFoundItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_found_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->string('item_title');
            $table->enum('item_type', ['lost', 'found'])->default('lost');
            $table->unsignedBigInteger('category_id');
            $table->text('description');
            $table->date('date_lost');
            $table->date('date_found')->nullable();
            $table->unsignedBigInteger('belongs_to');
            $table->unsignedBigInteger('found_by')->nullable();
            $table->unsignedBigInteger('claimed_by')->nullable();
            $table->date('date_claimed')->nullable();
            $table->string('location');
            $table->enum('status', ['claimed', 'unclaimed', 'closed'])->default('unclaimed');
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
        Schema::dropIfExists('lost_found_items');
    }
}
