<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMySystemAdminModifyLastLoginIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_system_admin', function (Blueprint $table) {
            $table->string('last_login_ip',50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_system_admin', function (Blueprint $table) {
            $table->string('last_login_ip',15)->change();
        });
    }
}
