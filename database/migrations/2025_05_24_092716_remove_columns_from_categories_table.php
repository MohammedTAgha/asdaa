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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'size',
                'date',
                'property1',
                'property2',
                'property3',
                'color',
                'amount'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('size')->nullable();
            $table->date('date')->nullable();
            $table->string('property1')->nullable();
            $table->string('property2')->nullable();
            $table->string('property3')->nullable();
            $table->string('color')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
        });
    }
};
