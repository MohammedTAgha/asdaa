<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('event_type'); // LOGIN, LOGOUT, CREATE, UPDATE, DELETE, EXPORT, IMPORT, etc.
            $table->string('model_type')->nullable(); // The model being affected (User, Citizen, etc.)
            $table->string('model_id')->nullable(); // ID of the affected model
            $table->text('description')->nullable(); // Human-readable description
            $table->json('old_values')->nullable(); // For updates
            $table->json('new_values')->nullable(); // For updates
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('metadata')->nullable(); // Additional contextual data
            $table->timestamps();
            
            $table->index(['event_type', 'model_type', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
