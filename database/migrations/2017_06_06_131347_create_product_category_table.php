<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->increments('product_category_id');

            $table->integer('parent')->unsigned();

            $table->string('name',100);
            $table->text('description')->nullable();
            $table->text('content')->nullable();

            $table->string('image',100)->nullable();

            $table->string('seo_title',100)->nullable();
            $table->string('seo_description',100)->nullable();
            $table->string('seo_keyword',100)->nullable();

            $table->integer('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent')->references('product_category_id')->on('product_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_category', function( Blueprint $table){
            $table->dropForeign('product_category_parent_foreign');
        });
    }
}
