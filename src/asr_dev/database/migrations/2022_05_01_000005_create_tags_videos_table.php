<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_videos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_tag_video');
            $table->unsignedBigInteger('id_tag');
            $table->unsignedBigInteger('id_video');
            $table->foreign('id_tag')->references('id_tag')->on('tags');
            $table->foreign('id_video')->references('id_video')->on('videos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_videos');
    }
}
