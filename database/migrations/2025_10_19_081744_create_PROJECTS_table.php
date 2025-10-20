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
        Schema::create('PROJECTS', function (Blueprint $table) {
            $table->integer('ID')->primary();
            
            $table->integer('USER_ID_PM');
            $table->integer('PROJECT_STATUS_ID');
            $table->string('project_name');
            $table->string('project_desc', 1023)->nullable();
            $table->date('project_start')->nullable();
            $table->date('project_date')->nullable();
            $table->json('project_links')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PROJECTS');
    }
};
