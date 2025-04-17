<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyArticleCategoryAddUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_article_category', function (Blueprint $table) {
            $table->string('redirect_url')->after('img')->default('')->comment('跳转URL');
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
            $table->dropColumn('redirect_url');
        });
    }
}
