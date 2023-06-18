<?php namespace Ovalsoft\Payment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUserProductTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_payment_user_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('email')->nullable();
            $table->integer('product_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ovalsoft_payment_user_products');
    }
}
