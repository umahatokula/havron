<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUserVideoTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_user_video', function (Blueprint $table) {
          $table->integer('user_id')->unsigned();
          $table->integer('video_id')->unsigned();
          $table->boolean('is_complete')->nullable();
          $table->date('last_watched')->nullable();
          $table->primary(['user_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_user_video');
    }
}
