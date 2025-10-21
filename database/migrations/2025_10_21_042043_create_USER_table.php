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
        Schema::create('USER', function (Blueprint $table) {
            $table->increments('ID')->unique('user_id_key');
            $table->string('user_name');
            $table->string('password');
            $table->string('user_desc', 1023)->nullable();
            $table->char('user_bg_color', 7)->nullable();
            $table->char('user_fg_color', 7)->nullable();
            $table->char('user_accent_color', 7)->nullable();

            $table->primary(['ID', 'user_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USER');
    }
};
