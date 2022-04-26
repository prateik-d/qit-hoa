<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifieds', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->text('description');
            $table->unsignedBigInteger('classified_category_id');
            $table->unsignedBigInteger('classified_condition_id');
            $table->decimal('asking_price', 10, 2);
            $table->date('date_posted');
            $table->unsignedBigInteger('posted_by');
            $table->unsignedBigInteger('purchase_by');
            $table->decimal('sale_price', 10, 2);
            $table->enum('status', ['open', 'sold'])->default('open');
            $table->tinyInteger('active_status')->default(1);
            $table->unsignedBigInteger('added_by');
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
        Schema::dropIfExists('classifieds');
    }
}
