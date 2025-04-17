<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_template', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->default('')->comment('名称');
            $table->string('title', 100)->default('')->comment('标题');
            $table->string('description')->default('')->comment('备注');
            $table->longText('content')->comment('内容');
            $table->string('ds_type')->default('')->comment('数据源类型');
            $table->text('json_data')->comment('json 数据源');
            $table->string('db_table')->default('')->comment('数据表');
            $table->string('db_condition')->default('')->comment('过滤条件');
            $table->string('db_action')->default('')->comment('后置操作');
            $table->integer('db_limit')->default('0')->comment('单次数量');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_mp_template');
    }
}
