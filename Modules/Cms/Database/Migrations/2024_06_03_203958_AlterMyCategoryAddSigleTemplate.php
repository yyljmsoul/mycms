<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyCategoryAddSigleTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_article_category', function (Blueprint $table) {
            $table->string('single_template')->after('template')
                ->default('')->comment('分类文章模板');
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
            $table->dropColumn('single_template');
        });
    }
}
