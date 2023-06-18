<?php namespace Ovalsoft\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProgramRegistrationUploadsTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_partners_program_registration_uploads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('program_registration_id')->nullable();
            $table->string('upload_type')->nullable();
            $table->string('original_name')->nullable();
            $table->string('size')->nullable();
            $table->string('extension')->nullable();
            $table->string('mime')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_partners_program_registration_uploads');
    }
}
