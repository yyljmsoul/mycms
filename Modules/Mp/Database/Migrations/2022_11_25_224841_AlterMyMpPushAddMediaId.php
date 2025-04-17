<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyMpPushAddMediaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_push_log', function (Blueprint $table) {
            $table->string('media_id')->after('appid')->default('')->comment('素材ID');
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
            $table->dropColumn('media_id');
        });
    }
}
