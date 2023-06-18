<?php namespace Ovalsoft\Payment\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddCountryIdUsersTable extends Migration
{

    public function up()
    {
        if (!Schema::hasColumn('users', 'country_id')) {
            Schema::table('users', function($table)
            {
            $table->integer('country_id')->nullable();
            });
        }
        Schema::table('users', function($table)
        {
            $table->string('country')->nullable();
            $table->string('shipping_address')->nullable();
        });
    }

    public function down()
    {
      if (Schema::hasColumn('users', 'country')) {
          Schema::table('users', function($table)
          {
              $table->dropColumn('country');
          });
      }
      if (Schema::hasColumn('users', 'shipping_address')) {
          Schema::table('users', function($table)
          {
              $table->dropColumn('shipping_address');
          });
      }
    }
}
