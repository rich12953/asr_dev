<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_tag_post');
            $table->unsignedBigInteger('id_tag');
            $table->unsignedBigInteger('id_post');
            $table->foreign('id_tag')->references('id_tag')->on('tags');
            $table->foreign('id_post')->references('id_post')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_posts');
    }
}
