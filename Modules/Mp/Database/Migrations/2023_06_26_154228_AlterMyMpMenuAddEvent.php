<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyMpMenuAddEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_menu', function (Blueprint $table) {

            $table->text('event_text')->after('path')->comment('回复内容');
            $table->string('event_image', 255)->after('event_text')->default('')->comment('回复图片');
            $table->string('event_media_id', 255)->after('event_text')->default('')->comment('图片MediaId');
            $table->string('event_key', 50)->after('event_image')->default('')->comment('事件KEY');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_mp_menu', function (Blueprint $table) {
            $table->dropColumn(['event_text', 'event_image', 'event_key']);
        });
    }
}
