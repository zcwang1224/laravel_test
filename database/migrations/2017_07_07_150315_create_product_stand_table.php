<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stand', function (Blueprint $table) {
            $table->increments('product_stand_id');

            $table->integer('product_item_id')->unsigned();

            $table->integer('price')->default(0);   //價格
            $table->integer('inventory')->default(0); // 庫存
            $table->string('product_stand_number')->nullable(); //商品編號

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
        Schema::dropIfExists('product_stand', function(Blueprint $table){
            $table->dropForeign('product_stand_product_item_id_foreign');
        });
    }
}
