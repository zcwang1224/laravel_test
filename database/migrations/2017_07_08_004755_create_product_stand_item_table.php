<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStandItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stand_item', function (Blueprint $table) {
            $table->increments('product_stand_item_id');

            $table->integer('product_stand_id')->unsigned();
            $table->integer('stand_id')->unsigned();
            $table->string('stand_item', 255);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_stand_id')->references('product_stand_id')->on('product_stand');
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
        Schema::dropIfExists('product_stand_item', function(Blueprint $table){
            $table->dropForeign('product_stand_item_product_stand_id_foreign');
            $table->dropForeign('product_stand_item_stand_id_foreign');
        });
    }
}
