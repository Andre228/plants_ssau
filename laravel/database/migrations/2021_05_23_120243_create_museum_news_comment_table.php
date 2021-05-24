<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMuseumNewsCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('museum_news_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('news_info_id')->unsigned();
            $table->bigInteger('news_id')->unsigned();
            $table->bigInteger('reply_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->text('comment')->nullable();

            $table->foreign('news_info_id')->references('id')->on('museum_news_info')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('museum_news_comments');
    }
}
