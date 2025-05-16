<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('citizen_id');
            $table->foreign('citizen_id')->references('id')->on('citizens')->onDelete('cascade');
            $table->string('firstname');
            $table->string('secondname')->nullable();
            $table->string('thirdname')->nullable();
            $table->string('lastname');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->enum('relationship', ['father', 'mother', 'son', 'daughter', 'other']);
            $table->boolean('is_accompanying')->default(false);
            $table->string('national_id')->unique();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
}; 