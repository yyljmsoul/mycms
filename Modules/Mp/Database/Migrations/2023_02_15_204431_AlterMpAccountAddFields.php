<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMpAccountAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_account', function (Blueprint $table) {
            $table->string('token')->after('app_key')
                ->default('')->comment('token');
            $table->string('aes_key')->after('token')
                ->default('')->comment('aes_key');
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
            $table->dropColumn(['token', 'aes_key']);
        });
    }
}
