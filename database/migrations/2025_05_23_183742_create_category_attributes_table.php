<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // e.g., 'text', 'number', 'date', 'select', etc.
            $table->text('description')->nullable();
            $table->boolean('is_required')->default(false);
            $table->json('options')->nullable(); // For select/multi-select options
            $table->json('validation_rules')->nullable(); // For validation rules
            $table->integer('order')->default(0); // For ordering attributes in forms
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_attributes');
    }
}; 