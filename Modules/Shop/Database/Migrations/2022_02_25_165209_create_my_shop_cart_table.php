<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyShopCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_shop_cart', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('goods_id');
            $table->integer('sku_id')->default('0');
            $table->integer('number')->default('0');
            $table->timestamps();

            $table->index(['user_id', 'goods_id', 'sku_id']);
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_shop_cart');
    }
}
