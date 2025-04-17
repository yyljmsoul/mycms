<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyMpPushAddAppid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_push_log', function (Blueprint $table) {
            $table->string('appid')->after('article_id')->default('')->comment('发布appid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_mp_push_log', function (Blueprint $table) {
            $table->dropColumn('appid');
        });
    }
}
