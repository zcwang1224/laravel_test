<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stand_item', function (Blueprint $table) {
            $table->increments('stand_item_id');

            $table->integer('stand_id')->unsigned();
            $table->string('stand_item_name', 255);
            $table->integer('sort')->default(1000);


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stand_id')->references('stand_id')->on('stand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stand_item', function(Blueprint $table){
            $table->dropForeign('stand_item_stand_id_foreign');
        });
    }
}
