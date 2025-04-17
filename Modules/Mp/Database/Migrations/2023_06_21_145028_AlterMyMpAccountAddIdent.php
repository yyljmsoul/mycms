<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyMpAccountAddIdent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_account', function (Blueprint $table) {
            $table->string('ident', 50)->after('aes_key')
                ->default('')->comment('标识')->index();
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
            $table->dropColumn(['ident']);
        });
    }
}
