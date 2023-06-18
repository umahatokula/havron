<?php namespace Ovalsoft\Payment\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUserProductsTable extends Migration
{
    public function up()
    {
        Schema::create('ovalsoft_payment_user_products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ovalsoft_payment_user_products');
    }
}
