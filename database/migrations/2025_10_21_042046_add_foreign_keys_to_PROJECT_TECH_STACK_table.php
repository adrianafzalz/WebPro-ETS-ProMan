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
        Schema::table('PROJECT_TECH_STACK', function (Blueprint $table) {
            $table->foreign(['PROJECTS_ID'], 'PROJECT_TECH_STACK_PROJECTS_ID_fkey')->references(['ID'])->on('PROJECTS')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['TECH_ID'], 'PROJECT_TECH_STACK_TECH_ID_fkey')->references(['ID'])->on('PROJECT_TECHS')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('PROJECT_TECH_STACK', function (Blueprint $table) {
            $table->dropForeign('PROJECT_TECH_STACK_PROJECTS_ID_fkey');
            $table->dropForeign('PROJECT_TECH_STACK_TECH_ID_fkey');
        });
    }
};
