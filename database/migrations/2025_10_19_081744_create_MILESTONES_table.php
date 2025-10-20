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
        Schema::create('MILESTONES', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('milestone_title')->nullable();

            $table->index(['ID'], 'table_6_mpn34fmhvdc97slrob1_index_0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MILESTONES');
    }
};
