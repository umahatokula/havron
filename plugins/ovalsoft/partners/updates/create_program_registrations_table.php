<?php namespace Ovalsoft\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateNexusRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_partners_program_registrations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('partner_id')->nullable();
            $table->integer('program_id')->nullable();
            $table->string('email')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country_of_residence')->nullable();
            $table->text('program_selections')->nullable();
            $table->string('degree')->nullable();
            $table->string('awarding_institution')->nullable();
            $table->string('class_of_degree')->nullable();
            $table->string('start_date')->nullable();
            $table->text('academic_transcript_file')->nullable();
            $table->text('cv_file')->nullable();
            $table->text('professional_or_academic_reference_file')->nullable();
            $table->text('mode_of_identification_file')->nullable();
            $table->string('declaration')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_partners_program_registrations');
    }
}
