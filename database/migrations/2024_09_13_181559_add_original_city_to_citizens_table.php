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
            $table->string('city')->nullable(); // Add city column
        });
    }
    
    public function down()
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->dropColumn('city'); // Remove city column
        });
    }
};
