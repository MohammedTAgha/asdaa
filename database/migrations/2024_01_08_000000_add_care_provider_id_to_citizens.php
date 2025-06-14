<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->foreignId('care_provider_id')
                  ->nullable()
                  ->references('id')
                  ->on('family_members')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->dropColumn('care_provider_id');
        });
    }
};
