<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyGoodsComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_shop_goods_comment', function (Blueprint $table) {
            $table->id();
            $table->integer('goods_id')->index();
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('star');
            $table->string('spec_name')->default('');
            $table->text('content');
            $table->text('reply');
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
        Schema::dropIfExists('my_shop_goods_comment');
    }
}
