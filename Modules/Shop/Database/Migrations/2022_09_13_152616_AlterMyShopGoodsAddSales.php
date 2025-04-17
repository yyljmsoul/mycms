<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyShopGoodsAddSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_shop_goods', function (Blueprint $table) {
            $table->integer('sales')->after('stock')->default('0')->comment('销量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_shop_goods', function (Blueprint $table) {
            $table->dropColumn('sales');
        });
    }
}
