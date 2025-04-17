<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyGoodsSpecValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_shop_goods_spec_value', function (Blueprint $table) {
            $table->id();
            $table->integer('goods_id');
            $table->integer('spec_id');
            $table->string('value')->default('');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->index(['goods_id', 'spec_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_shop_goods_spec_value');
    }
}
