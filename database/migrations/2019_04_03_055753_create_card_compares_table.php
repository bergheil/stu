<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardComparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_compares', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('card_1_id');
            $table->unsignedBigInteger('card_2_id');
            $table->smallInteger('point');
            $table->unique(['card_1_id', 'card_2_id']);
            $table->foreign('card_1_id')->references('id')->on('card');
            $table->foreign('card_2_id')->references('id')->on('card');
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
        Schema::dropIfExists('card_compares');
    }
}
