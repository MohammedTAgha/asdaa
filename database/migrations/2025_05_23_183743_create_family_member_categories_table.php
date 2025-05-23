<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('family_member_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_attribute_id')->constrained()->onDelete('cascade');
            $table->text('value')->nullable();
            $table->text('notes')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->default('pending'); // e.g., 'pending', 'approved', 'rejected'
            $table->timestamps();
            $table->softDeletes();

            // Add unique constraint to prevent duplicate attribute values for the same family member
            $table->unique(['family_member_id', 'category_id', 'category_attribute_id'], 'unique_family_member_category_attribute');
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_member_categories');
    }
}; 