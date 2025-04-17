<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyDiyPageAddTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_diy_page', function (Blueprint $table) {
            $table->string('page_template')->after('lang')->default("")->comment('页面模板');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_diy_page', function (Blueprint $table) {
            $table->dropColumn('page_template');
        });
    }
}
