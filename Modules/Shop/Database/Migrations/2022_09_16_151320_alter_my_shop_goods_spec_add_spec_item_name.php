<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMyShopGoodsSpecAddSpecItemName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_shop_goods_spec', function (Blueprint $table) {
            $table->string('spec_item_name')->after('spec_name')->default('')->comment('商品规格名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_shop_goods_spec', function (Blueprint $table) {
            $table->dropColumn('spec_item_name');
        });
    }
}
