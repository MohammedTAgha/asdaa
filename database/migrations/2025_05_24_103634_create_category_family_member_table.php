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
        Schema::create('category_family_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->string('size')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('property1')->nullable();
            $table->string('property2')->nullable();
            $table->string('property3')->nullable();
            $table->string('property4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_family_member');
    }
};
