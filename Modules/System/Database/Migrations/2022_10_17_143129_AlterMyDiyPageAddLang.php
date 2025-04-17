<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyDiyPageAddLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_diy_page', function (Blueprint $table) {
            $table->string('lang', 30)->after('page_name')->default("")->comment('语言版本');
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
            $table->dropColumn('lang');
        });
    }
}
