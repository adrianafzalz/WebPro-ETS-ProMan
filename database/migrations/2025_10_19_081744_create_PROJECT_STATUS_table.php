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
        Schema::create('PROJECT_STATUS', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('status_name')->nullable();
            $table->string('status_icon_url', 1023)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PROJECT_STATUS');
    }
};
