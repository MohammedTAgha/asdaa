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
    {        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('event_type'); // LOGIN, LOGOUT, CREATE, UPDATE, DELETE, EXPORT, IMPORT
            $table->string('model_type')->nullable(); // The model being affected (e.g., Citizen, Distribution)
            $table->string('model_id')->nullable(); // ID of the affected model
            $table->text('description')->nullable(); // Human-readable description of the action
            $table->text('old_values')->nullable(); // JSON of old values for updates
            $table->text('new_values')->nullable(); // JSON of new values for updates
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('event_type');
            $table->index('model_type');
            $table->index('model_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
