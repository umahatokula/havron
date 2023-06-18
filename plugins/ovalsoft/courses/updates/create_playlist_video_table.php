<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePlaylistVideoTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_playlist_video', function (Blueprint $table) {
          $table->integer('playlist_id')->unsigned();
          $table->integer('video_id')->unsigned();
          $table->primary(['playlist_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_playlist_video');
    }
}
