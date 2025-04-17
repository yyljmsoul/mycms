<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyDirectMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_direct_mail', function (Blueprint $table) {
            $table->id();
            $table->string('access_key', 50);
            $table->string('access_secret', 50);
            $table->string('account_name', 100);
            $table->string('remark');
            $table->tinyInteger('is_default')->default('0');
            $table->string('region', 50);
            $table->string('alias', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_direct_mail');
    }
}
