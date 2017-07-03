<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_item', function (Blueprint $table) {
            $table->increments('news_item_id');

            $table->integer('news_category_id')->unsigned();

            $table->string('name'               , 100);
            $table->string('image'              , 100)->nullable();
            $table->string('seo_title'          , 100)->nullable();
            $table->string('seo_description'    , 100)->nullable();
            $table->string('seo_keyword'        , 100)->nullable();

            $table->text('content')->nullable();

            $table->integer('status')->default(1);          
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('news_category_id')->references('news_category_id')->on('news_category')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_item', function (Blueprint $table) {

            $table->dropForeign('news_item_news_category_id_foreign');
        });
    }
}
