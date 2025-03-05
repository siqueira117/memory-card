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
        Schema::create('tbl_game_platforms', function (Blueprint $table) {
            $table->id('game_platforms_id');

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
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_game_platforms');
    }
};
