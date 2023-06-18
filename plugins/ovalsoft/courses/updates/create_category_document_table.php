<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoryDocumentTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_cat_doc', function (Blueprint $table) {
          $table->integer('category_id')->unsigned();
          $table->integer('document_id')->unsigned();
          $table->primary(['category_id', 'document_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_cat_doc');
    }
}
