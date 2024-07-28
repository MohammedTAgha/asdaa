<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->string('firstname')->after('name');
            $table->string('secondname')->after('firstname');
            $table->string('thirdname')->after('secondname');
            $table->string('lastdname')->after('thirdname');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('citizens', function (Blueprint $table) {
            //
            $table->dropColumn('firstname');
            $table->dropColumn('secondname');
            $table->dropColumn('thirdname');
            $table->dropColumn('lastdname');
        });
    }
};
