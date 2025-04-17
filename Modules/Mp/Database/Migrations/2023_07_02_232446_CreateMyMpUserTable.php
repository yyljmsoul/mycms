<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_user', function (Blueprint $table) {
            $table->id();
            $table->integer('mp_id')->default('0')->comment('公众号');
            $table->string('openid', 50)->default('')->comment('openid');
            $table->string('unionid', 50)->default('')->comment('unionid');
            $table->string('tagid_list', 50)->default('')->comment('标签');
            $table->string('subscribe_scene', 50)->default('')->comment('关注来源');
            $table->string('qr_scene', 50)->default('')->comment('二维码');
            $table->integer('subscribe_time')->default('0')->comment('关注时间');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->index(['mp_id', 'openid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_mp_user');
    }
}
