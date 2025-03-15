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
        Schema::create('tbl_game_manuals', function (Blueprint $table) {
            $table->id('game_manual_id');

            $table->string('url', 255);

            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
              ->references('game_id')
              ->on('tbl_games')
              ->onDelete('cascade');        
            
            $table->unsignedBigInteger('platform_id');
            $table->foreign('platform_id')
              ->references('platform_id')
              ->on('tbl_platforms')
              ->onDelete('cascade');

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')
              ->references('language_id')
              ->on('tbl_languages')
              ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_game_manuals');
    }
};
