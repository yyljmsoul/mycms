<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyApiSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_api_source', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->default('')->comment('数据源名称');
            $table->string('source_type', 30)->default('')->comment('数据源类型');
            $table->string('request_url')->default('')->comment('转发请求URL');
            $table->string('table_name', 100)->default('')->comment('数据表');
            $table->longText('table_fields')->comment('数据字段');
            $table->string('remark')->default('')->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_api_source');
    }
}
