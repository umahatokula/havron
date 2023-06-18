<?php namespace Ovalsoft\Lecturers\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLecturersTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_lecturers_lecturers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('profile_picture')->nullable();
            $table->text('description')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('designation')->nullable();
            $table->string('website')->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('awards')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('skype')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_lecturers_lecturers');
    }
}
