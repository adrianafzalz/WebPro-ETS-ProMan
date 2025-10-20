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
        Schema::table('PROJECTS', function (Blueprint $table) {
            $table->foreign(['PROJECT_STATUS_ID'], 'PROJECTS_PROJECT_STATUS_ID_fkey')->references(['ID'])->on('PROJECT_STATUS')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['USER_ID_PM'], 'PROJECTS_USER_ID_PM_fkey')->references(['ID'])->on('USER')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('PROJECTS', function (Blueprint $table) {
            $table->dropForeign('PROJECTS_PROJECT_STATUS_ID_fkey');
            $table->dropForeign('PROJECTS_USER_ID_PM_fkey');
        });
    }
};
