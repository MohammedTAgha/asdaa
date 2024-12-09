<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('region_representatives', function (Blueprint $table) {
            $table->boolean('is_big_region_representative')->default(false);
        });
    }

    public function down()
    {
        Schema::table('region_representatives', function (Blueprint $table) {
            $table->dropColumn('is_big_region_representative');
        });
    }
};
