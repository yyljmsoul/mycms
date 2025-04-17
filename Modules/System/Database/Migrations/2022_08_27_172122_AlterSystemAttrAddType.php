<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSystemAttrAddType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_system_attr', function (Blueprint $table) {
            $table->string('type', 15)->after('name')->default("cms");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_system_attr', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
