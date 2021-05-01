<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMuseumPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('museum_posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('category_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('inventory_number');

            $table->string('slug')->unique();
            $table->json('coordinates');

            $table->string('title');
            $table->text('excerpt')->nullable();

            $table->text('content_raw');
            $table->text('content_html');

            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('author');
            $table->timestamp('collection_date')->nullable();

            $table->bigInteger('barcode')->nullable();
            $table->string('adopted_name', 550)->nullable();
            $table->string('russian_name', 350)->nullable();
            $table->string('label_text', 350)->nullable();//accuracy
            $table->integer('accuracy')->nullable();
            $table->string('collectors')->nullable();
            $table->string('determination')->nullable();
            $table->float('environmental_status')->nullable();
            $table->string('label_name', 550)->nullable();



            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('museum_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->index('is_published');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('museum_posts');
    }
}
