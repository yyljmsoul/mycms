<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMyApiAddProjectIdent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_api', function (Blueprint $table) {
            $table->string('project_ident', 50)->default('')->comment('项目标识');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_api', function (Blueprint $table) {
            $table->dropColumn(['project_ident']);
        });
    }
}
