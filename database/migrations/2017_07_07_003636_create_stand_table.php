<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stand', function (Blueprint $table) {
            $table->increments('stand_id');

            $table->integer('product_item_id')->unsigned();
            $table->string('stand_name', 255);
            $table->string('stand_item', 255)->nullable();
            $table->integer('sort')->default(1000);


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_item_id')->references('product_item_id')->on('product_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stand', function(Blueprint $table){
            $table->dropForeign('stand_product_item_id_foreign');
        });
    }
}
