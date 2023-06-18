<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePlaylistUsergroupTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_group_playlist', function (Blueprint $table) {
          $table->integer('group_id')->unsigned();
          $table->integer('playlist_id')->unsigned();
          $table->primary(['group_id', 'playlist_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_group_playlist');
    }
}
