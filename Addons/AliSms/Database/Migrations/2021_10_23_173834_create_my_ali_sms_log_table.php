<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyAliSmsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_ali_sms_log', function (Blueprint $table) {
            $table->id();
            $table->integer('sms_id');
            $table->char('mobile', 11);
            $table->string('params', 100);
            $table->string('response');
            $table->timestamps();

            $table->index(['sms_id', 'mobile']);
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
        Schema::dropIfExists('my_ali_sms_log');
    }
}
