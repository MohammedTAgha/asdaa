<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('big_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('representative_id')->nullable(); // Big region representative
            $table->foreign('representative_id')->references('id')->on('region_representatives')->onDelete('set null');
            $table->timestamps();
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->unsignedBigInteger('big_region_id')->nullable(); // Associate regions with big regions
            $table->foreign('big_region_id')->references('id')->on('big_regions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign(['big_region_id']);
            $table->dropColumn('big_region_id');
        });

        Schema::dropIfExists('big_regions');
    }
};
