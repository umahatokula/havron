<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAudioCourseTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_audio_course', function (Blueprint $table) {
          $table->integer('audio_id')->unsigned();
          $table->integer('course_id')->unsigned();
          $table->primary(['audio_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_audio_course');
    }
}
