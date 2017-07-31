<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system', function (Blueprint $table) {
            $table->increments('system_id');

            $table->string('name', 255);
            $table->string('image', 255)->nullable();

            $table->text('content')->nullable();
            $table->text('content1')->nullable();
            $table->text('content2')->nullable();

            $table->string('seo_title', 255)->nullable();
            $table->string('seo_keyword', 255)->nullable();
            $table->string('seo_description', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system');
    }
}
