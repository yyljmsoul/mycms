<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_code', function (Blueprint $table) {
            $table->id();
            $table->integer('mp_id')->default('0')->comment('公众号');
            $table->string('name', 50)->default('')->comment('二维码名称');
            $table->string('code_type', 20)->default('')->comment('二维码类型');
            $table->string('reply_type', 50)->default('')->comment('回复类型');
            $table->text('reply_content')->comment('回复内容');
            $table->string('reply_image')->default('')->comment('回复图片');
            $table->string('reply_media_id')->default('')->comment('回复图片Media_id');
            $table->integer('tag_id')->default('0')->comment('用户标签');
            $table->string('code_image')->default('')->comment('二维码图片');
            $table->integer('subscribe_count')->default('0')->comment('关注用户数量');
            $table->integer('scan_count')->default('0')->comment('扫描数量');
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
        Schema::dropIfExists('my_mp_code');
    }
}
