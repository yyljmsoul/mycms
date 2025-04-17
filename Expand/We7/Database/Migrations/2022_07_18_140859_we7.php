<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class We7 extends Migration
{

    protected $tables = [
        "my_article",
        "my_article_category",
        "my_article_category_meta",
        "my_article_comment",
        "my_article_meta",
        "my_article_tag",
        "my_article_tag_rel",
        "my_order",
        "my_order_goods",
        "my_diy_page",
        "my_pay_log",
        "my_shop_cart",
        "my_shop_category_meta",
        "my_shop_goods",
        "my_shop_goods_albums",
        "my_shop_goods_category",
        "my_shop_goods_meta",
        "my_system_admin",
        "my_system_attr",
        "my_system_config",
        "my_system_menu",
        "my_system_role",
        "my_user",
        "my_user_address",
        "my_user_balance",
        "my_user_meta",
        "my_user_point",
        "my_user_rank",
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        foreach ($this->tables as $item) {

            Schema::table($item, function (Blueprint $table) {
                $table->integer('uniacid')->after('id')->default('0');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $item) {

            Schema::table($item, function (Blueprint $table) {
                $table->dropColumn('uniacid');
            });
        }
    }
}
