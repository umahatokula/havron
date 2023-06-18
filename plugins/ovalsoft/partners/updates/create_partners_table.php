<?php namespace Ovalsoft\Partners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePartnersTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_partners_partners', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('is_active')->default(1);
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('information')->nullable();
            $table->string('image')->nullable();
            $table->string('form_is_external')->nullable();
            $table->string('external_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_partners_partners');
    }
}
