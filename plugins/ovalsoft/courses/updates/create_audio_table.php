<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAudioTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_audio', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('source')->nullable();
            // $table->string('file_path');
            $table->string('remote_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_audio');
    }
}
