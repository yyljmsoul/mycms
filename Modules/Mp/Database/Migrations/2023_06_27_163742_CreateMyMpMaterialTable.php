<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyMpMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_mp_material', function (Blueprint $table) {
            $table->id();
            $table->integer('mp_id')->default('0')->comment('公众号');
            $table->string('url', 255)->default('')->comment('素材地址');
            $table->string('media_id', 80)->default('')->comment('素材ID');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->index(['mp_id', 'media_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_mp_material');
    }
}
