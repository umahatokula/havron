<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCourseVideoTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_course_video', function (Blueprint $table) {
          $table->integer('course_id')->unsigned();
          $table->integer('video_id')->unsigned();
          $table->primary(['course_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_course_video');
    }
}
