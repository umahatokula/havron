<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_courses_courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('code', 180)->index()->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->double('price', 15,2)->default(0.00);
            $table->decimal('old_price', 10, 2)->nullable()->default(0.00);
            $table->string('currency', 10);
            $table->integer('product_id')->nullable()->comment('Corresponsding product in shop');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_courses_courses');
    }
}
