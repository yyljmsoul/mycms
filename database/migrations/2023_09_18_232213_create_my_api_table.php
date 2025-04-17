<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_api', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->default('')->comment('接口名称');
            $table->string('path', 100)->default('')->comment('API接口地址');
            $table->string('method', 20)->default('')->comment('API请求方法');
            $table->string('source_type', 20)->default('')->comment('数据源类型');
            $table->string('return_type', 20)->default('')->comment('返回类型');
            $table->string('request_url')->default('')->comment('转发请求URL');
            $table->string('table_name', 100)->default('')->comment('数据表');
            $table->text('params')->nullable()->comment('请求参数');
            $table->text('fields')->nullable()->comment('返回字段');
            $table->longText('response')->comment('响应内容');
            $table->timestamps();

            $table->unique(['path']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_api');
    }
}
