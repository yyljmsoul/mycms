<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyApiProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_api_project', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->default('')->comment('项目名称');
            $table->string('description', 255)->default('')->comment('项目描述');
            $table->string('ident', 50)->default('')->comment('项目key');
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
        Schema::dropIfExists('my_api_project');
    }
}
