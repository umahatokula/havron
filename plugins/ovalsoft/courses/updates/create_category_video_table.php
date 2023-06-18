<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoryVideoTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_category_video', function (Blueprint $table) {
          $table->integer('category_id')->unsigned();
          $table->integer('video_id')->unsigned();
          $table->primary(['category_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_category_video');
    }
}
