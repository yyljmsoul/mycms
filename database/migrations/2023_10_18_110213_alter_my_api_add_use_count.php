<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMyApiAddUseCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_api', function (Blueprint $table) {
            $table->integer('use_count')->default('0')->comment('接口使用次数');
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
            $table->dropColumn(['use_count']);
        });
    }
}
