<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemImageTale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_item_image', function (Blueprint $table) {
            $table->increments('product_item_image_id');

            $table->integer('product_item_id')->unsigned();

            $table->string('image_path'     , 255)->nullable();
            $table->string('image_thumbnail', 255)->nullable();
            $table->string('image_comment'  , 255)->nullable();

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
        Schema::dropIfExists('product_item_image', function(Blueprint $table){
            $table->dropForeign('product_item_image_product_item_id_foreign'     );
        });
    }
}
