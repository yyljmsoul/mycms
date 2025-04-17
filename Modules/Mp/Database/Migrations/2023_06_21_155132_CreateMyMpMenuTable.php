<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('mp_id')->comment('公众号');
            $table->integer('pid')->comment('上级');
            $table->integer('sort')->comment('排序(小数在前面)');
            $table->string('name', 50)->comment('菜单名称');
            $table->string('type', 30)->comment('菜单类型');
            $table->string('url', 255)->comment('链接');
            $table->string('appid', 50)->comment('appid');
            $table->string('path', 50)->comment('小程序地址');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->index(['mp_id', 'pid', 'sort']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_mp_menu');
    }
}
