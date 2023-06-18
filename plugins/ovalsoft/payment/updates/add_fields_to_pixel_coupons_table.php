<?php namespace Ovalsoft\Payment\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddFieldsToPixelCouponsTable extends Migration
{

    public function up()
    {
        Schema::table('pixel_shop_coupons', function($table)
        {
            $table->integer('user_group_id')->nullable();
        });
    }

    public function down()
    {
      if (Schema::hasColumn('pixel_shop_coupons', 'user_group_id')) {
          Schema::table('pixel_shop_coupons', function($table)
          {
              $table->dropColumn('user_group_id');
          });
      }
    }
}
