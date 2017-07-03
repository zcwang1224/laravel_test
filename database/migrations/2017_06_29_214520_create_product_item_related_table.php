<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_item_related', function (Blueprint $table) {
            //
            $table->increments('product_item_related_id');

            $table->integer('product_item_id'   )->unsigned();
            $table->integer('product_related_id')->unsigned();

            $table->timestamps();
            $table->softDeletes(); 
            
            $table->foreign('product_item_id'   )->references('product_item_id'  )->on('product_item');
            $table->foreign('product_related_id')->references('product_item_id'  )->on('product_item');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_item_related', function (Blueprint $table) {
            //
            $table->dropForeign('product_item_related_product_item_id_foreign'     );
            $table->dropForeign('product_item_related_product_related_id_foreign'  );
        });
    }
}
