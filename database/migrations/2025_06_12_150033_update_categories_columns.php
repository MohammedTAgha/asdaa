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
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('amount')->nullable()->change();
            $table->string('date')->nullable()->change();
            $table->string('size')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->string('size')->nullable()->change();
        });
    }
};
