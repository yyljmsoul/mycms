<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMyApiAddCountField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_api', function (Blueprint $table) {
            $table->string('count_field', 50)->default('')->comment('统计次数字段');
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
            $table->dropColumn(['count_field']);
        });
    }
}
