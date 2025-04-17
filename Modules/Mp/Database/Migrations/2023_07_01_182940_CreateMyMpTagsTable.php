<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('mp_id')->default('0')->comment('公众号');
            $table->integer('tag_id')->default('0')->comment('用户标签ID');
            $table->string('name', 50)->default('')->comment('标签名称');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->index(['mp_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_mp_tags');
    }
}
