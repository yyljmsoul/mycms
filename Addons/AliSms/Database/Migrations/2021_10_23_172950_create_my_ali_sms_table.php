<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyAliSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_ali_sms', function (Blueprint $table) {
            $table->id();
            $table->string('access_key', 50);
            $table->string('access_secret', 50);
            $table->string('sign_name', 50);
            $table->string('template_code', 50);
            $table->tinyInteger('is_default')->default(0);
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
        Schema::dropIfExists('my_ali_sms');
    }
}
