<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyArticleCategoryAddSubname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_article_category', function (Blueprint $table) {
            $table->string('sub_name')->after('template')->default('')->comment('子名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_article_category', function (Blueprint $table) {
            $table->dropColumn('sub_name');
        });
    }
}
