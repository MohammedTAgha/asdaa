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
            // Update the citizens table to include soft deletes, is_archived, and verified fields.
Schema::table('citizens', function (Blueprint $table) {
    $table->softDeletes(); // Adds deleted_at column for soft deletes
    $table->boolean('is_archived')->default(false); // Archived flag
});
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
        });
    }
};
