<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_order_goods', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->index();
            $table->integer('user_id');
            $table->integer('goods_id');
            $table->string('goods_name');
            $table->string('goods_image');
            $table->decimal('market_price');
            $table->decimal('shop_price');
            $table->integer('number');
            $table->decimal('goods_money');
            $table->timestamps();

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
        Schema::dropIfExists('my_order_goods');
    }
}
