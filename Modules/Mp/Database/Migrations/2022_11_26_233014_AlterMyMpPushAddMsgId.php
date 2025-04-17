<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyMpPushAddMsgId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_push_log', function (Blueprint $table) {
            $table->string('msg_id')->after('media_id')->default('')->comment('群发消息后返回的消息id');
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
            $table->dropColumn('msg_id');
        });
    }
}
