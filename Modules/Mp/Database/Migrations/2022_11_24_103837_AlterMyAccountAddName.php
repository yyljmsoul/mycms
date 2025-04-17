<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyAccountAddName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_account', function (Blueprint $table) {
            $table->string('name')->after('id')->default('')->comment('账号名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_mp_account', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
