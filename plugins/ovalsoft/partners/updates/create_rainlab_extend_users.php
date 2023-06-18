<?php namespace Pixel\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRainlabExtendUsers extends Migration
{
    public function up()
    {

        Schema::table('users', function($table)
        {
            $table->text('payment_country')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table)
        {
            if (Schema::hasColumn('users', 'payment_country')) {
                $table->dropColumn('payment_country');
            }
        });
    }
    

}