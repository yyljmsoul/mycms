<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMyNavAddLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_nav', function (Blueprint $table) {
            $table->string('lang')->after('style_css')->default('');
            $table->integer('lang_ident')->after('lang')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_nav', function (Blueprint $table) {
            $table->dropColumn(['lang', 'lang_ident']);
        });
    }
}
