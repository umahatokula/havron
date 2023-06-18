<?php namespace Ovalsoft\Courses\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdatePixelShopItemsTable extends Migration
{
    public function up()
    {
        Schema::table('pixel_shop_items', function($table) {
          $table->boolean('is_virtual')->nullable()->default(0);
        });
    }

    public function down()
    {
		if (Schema::hasColumns('pixel_shop_items', ["is_virtual"]))			
		{	
			Schema::table('pixel_shop_items', function($table) {
				$table->dropColumn('shipping_fee');
			});
		}
    }
}
