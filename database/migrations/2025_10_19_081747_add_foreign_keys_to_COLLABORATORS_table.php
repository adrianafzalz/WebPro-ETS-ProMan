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
        Schema::table('COLLABORATORS', function (Blueprint $table) {
            $table->foreign(['PROJECTS_ID'], 'COLLABORATORS_PROJECTS_ID_fkey')->references(['ID'])->on('PROJECTS')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['USER_ID'], 'COLLABORATORS_USER_ID_fkey')->references(['ID'])->on('USER')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('COLLABORATORS', function (Blueprint $table) {
            $table->dropForeign('COLLABORATORS_PROJECTS_ID_fkey');
            $table->dropForeign('COLLABORATORS_USER_ID_fkey');
        });
    }
};
