<?php namespace Ovalsoft\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_partners_programs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('is_active')->default(1);
            $table->integer('partner_id');
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('total_units')->nullable();
            $table->text('duration')->nullable();
            $table->text('external_form_link')->nullable();
            $table->text('introduction')->nullable();
            $table->text('program_structure')->nullable();
            $table->string('mode_of_study')->nullable();
            $table->text('mode_of_study_description')->nullable();
            $table->text('assessment')->nullable();
            $table->text('eligibility')->nullable();
            $table->text('academic_support')->nullable();
            $table->text('career_opportunities')->nullable();
            $table->text('others')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_partners_programs');
    }
}
