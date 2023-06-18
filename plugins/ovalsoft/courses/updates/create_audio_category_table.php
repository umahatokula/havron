<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAudioCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_audio_cat', function (Blueprint $table) {
          $table->integer('audio_id')->unsigned();
          $table->integer('category_id')->unsigned();
          $table->primary(['audio_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_audio_cat');
    }
}
