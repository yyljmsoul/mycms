<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('order_sn', 50)->unique();
            $table->string('out_trade_no', 50)->default('');
            $table->decimal('order_amount')->default('0');
            $table->decimal('goods_money')->default('0');
            $table->decimal('delivery_money')->default('0');
            $table->smallInteger('order_status')->default('0');
            $table->smallInteger('pay_status')->default('0');
            $table->smallInteger('delivery_status')->default('0');
            $table->string('pay_type', 30)->default('');
            $table->string('delivery_type', 30)->default('');
            $table->string('delivery_code', 30)->default('');
            $table->string('receive_name', 30)->default('');
            $table->string('receive_telephone', 30)->default('');
            $table->integer('receive_province')->default('0');
            $table->integer('receive_city')->default('0');
            $table->integer('receive_district')->default('0');
            $table->string('receive_address')->default('');
            $table->integer('create_time')->default('0');
            $table->integer('pay_time')->default('0');
            $table->integer('delivery_time')->default('0');
            $table->integer('close_time')->default('0');
            $table->integer('finish_time')->default('0');
            $table->integer('refund_time')->default('0');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('my_order');
    }
}
