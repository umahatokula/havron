<?php namespace Ovalsoft\MajicFormsMailer\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMailersTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_majicformsmailer_mailers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('group');
            $table->string('subject');
            $table->boolean('use_template');
            $table->text('message');
            $table->string('mail_template');
            $table->boolean('processed')->default(FALSE);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_majicformsmailer_mailers');
    }
}
