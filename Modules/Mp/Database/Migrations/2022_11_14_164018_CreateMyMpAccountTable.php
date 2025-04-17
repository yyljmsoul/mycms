<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_account', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->comment('平台类型');
            $table->string('app_id', 50)->comment('AppId');
            $table->string('app_key')->comment('AppKey');
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
        Schema::dropIfExists('my_mp_account');
    }
}
