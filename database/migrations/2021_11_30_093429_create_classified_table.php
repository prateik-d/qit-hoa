<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classified', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classified_category_id');
            $table->unsignedBigInteger('classified_condition_id');
            $table->unsignedBigInteger('posted_by');
            $table->string('title',100);
            $table->text('description');
            $table->string('price',100);
            $table->string('image');
            $table->tinyInteger('status');
            $table->tinyInteger('active');
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
        Schema::dropIfExists('classified');
    }
}
