<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyCategoryAddKeyword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_shop_goods_category', function (Blueprint $table) {
            $table->string('keyword')->after('name')->default('')->comment('关键词');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_shop_goods_category', function (Blueprint $table) {
            $table->dropColumn('keyword');
        });
    }
}
