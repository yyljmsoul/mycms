<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyOrderGoodsAddSku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_order_goods', function (Blueprint $table) {
            $table->integer('sku_id')->default('0')->comment('SKU ID');
            $table->string('sku_val')->default('')->comment('SKU 信息');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_order_goods', function (Blueprint $table) {
            $table->dropColumn(['sku_id', 'sku_val']);
        });
    }
}
