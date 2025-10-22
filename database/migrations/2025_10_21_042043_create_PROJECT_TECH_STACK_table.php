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
        Schema::create('PROJECT_TECH_STACK', function (Blueprint $table) {
            $table->increments('ID')->primary();
            $table->integer('TECH_ID')->nullable();
            $table->integer('PROJECTS_ID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PROJECT_TECH_STACK');
    }
};
