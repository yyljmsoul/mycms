<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyUserAddOpenid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_user', function (Blueprint $table) {
            $table->string('unionid',50)->after('password')->default('')->index();
            $table->string('openid',50)->after('password')->default('')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_user', function (Blueprint $table) {
            $table->dropColumn(['unionid', 'openid']);
        });
    }
}
