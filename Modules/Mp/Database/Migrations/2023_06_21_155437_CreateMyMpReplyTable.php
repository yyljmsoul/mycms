<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_reply', function (Blueprint $table) {
            $table->id();
            $table->integer('mp_id')->comment('公众号');
            $table->string('type', 20)->default('')->comment('模式');
            $table->string('keyword', 50)->default('')->comment('关键词');
            $table->text('reply_content')->comment('回复内容');
            $table->string('reply_type', 50)->default('')->comment('回复类型');
            $table->string('reply_image')->default('')->comment('回复图片');
            $table->string('reply_media_id')->default('')->comment('回复图片Media_id');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->index(['mp_id', 'type', 'keyword']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_mp_reply');
    }
}
