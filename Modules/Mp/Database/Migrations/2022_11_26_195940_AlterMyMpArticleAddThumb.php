<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMyMpArticleAddThumb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_mp_article', function (Blueprint $table) {
            $table->string('thumb')->after('content_source_url')->default('')->comment('缩略图');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_mp_article', function (Blueprint $table) {
            $table->dropColumn(['thumb']);
        });
    }
}
