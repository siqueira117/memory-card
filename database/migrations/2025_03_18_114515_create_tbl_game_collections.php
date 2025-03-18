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
        Schema::create('tbl_game_collections', function (Blueprint $table) {
            $table->id('game_collection_id');
            
            $table->unsignedBigInteger('collection_id');
            $table->foreign('collection_id')
              ->references('collection_id')
              ->on('tbl_collections')
              ->onDelete('cascade');

            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
              ->references('game_id')
              ->on('tbl_games')
              ->onDelete('cascade');   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_game_collections');
    }
};
