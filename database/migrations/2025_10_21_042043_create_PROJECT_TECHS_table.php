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
        Schema::create('PROJECT_TECHS', function (Blueprint $table) {
            $table->increments('ID')->primary();
            $table->string('tech_icon_url', 1023)->nullable();
            $table->string('tech_name');
            $table->char('tech_color', 7);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PROJECT_TECHS');
    }
};
