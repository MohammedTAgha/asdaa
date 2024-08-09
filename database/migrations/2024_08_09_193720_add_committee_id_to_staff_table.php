<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('staff', function (Blueprint $table) {
        $table->unsignedBigInteger('committee_id')->nullable();
        $table->foreign('committee_id')->references('id')->on('committees')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('staff', function (Blueprint $table) {
        $table->dropForeign(['committee_id']);
        $table->dropColumn('committee_id');
    });
}
};
