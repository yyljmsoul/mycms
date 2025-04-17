<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_nav', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('url')->default('');
            $table->integer('pid')->default('0');
            $table->string('ico')->nullable();
            $table->string('target')->default('');
            $table->integer('sort')->default('0');
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
        Schema::dropIfExists('my_nav');
    }
}
