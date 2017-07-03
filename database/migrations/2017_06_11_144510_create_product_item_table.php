<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_item', function (Blueprint $table) {
            $table->increments('product_item_id');

            $table->integer('product_category_id')->unsigned();
            $table->string('name',  100);
            $table->string('image'              , 100)->nullable();
            $table->text('description1'  )->nullable();
            $table->text('description2'  )->nullable();
            $table->text('content1'      )->nullable(); // 商品特色
            $table->text('content2'      )->nullable(); // 商品規格
            $table->text('content3'      )->nullable(); // 退/換貨需知
            $table->text('content4'      )->nullable(); // 其他

            $table->string('seo_title'      , 100)->nullable();
            $table->string('seo_description', 100)->nullable();
            $table->string('seo_keyword'    , 100)->nullable();

            $table->integer('sort'  )->default(1000);
            $table->integer('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_category_id')->references('product_category_id')->on('product_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_item', function(Blueprint $table){
            $table->dropForeign('product_item_product_category_id_foreign');
        });
    }
}
