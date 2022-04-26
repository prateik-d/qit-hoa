<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voting_category_id');
            $table->text('description');
            $table->string('year');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('vote_option')->default(0)->nullable()->comment = '1-all owners';
            $table->text('voting_winner')->nullable();
            $table->enum('status', ['open', 'closed', 'archived'])->default('open');
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
        Schema::dropIfExists('votings');
    }
}
