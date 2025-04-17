<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyGoodsSpec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_shop_goods_spec', function (Blueprint $table) {
            $table->id();
            $table->integer('goods_id')->index();
            $table->string('spec_name')->default('');
            $table->string('spec_key')->default('');
            $table->integer('stock')->default('0');
            $table->string('img')->default('');
            $table->decimal('market_price', 10)->default('0');
            $table->decimal('shop_price', 10)->default('0');
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
        Schema::dropIfExists('my_shop_goods_spec');
    }
}
