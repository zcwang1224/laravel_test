<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_category', function (Blueprint $table) {
            $table->increments('news_category_id');

            $table->string('name'               , 100);
            $table->string('image'              , 100)->nullable();
            $table->string('seo_title'          , 100)->nullable();
            $table->string('seo_description'    , 100)->nullable();
            $table->string('seo_keyword'        , 100)->nullable();

            $table->text('content')->nullable();

            $table->integer('status')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_category');
    }
}
