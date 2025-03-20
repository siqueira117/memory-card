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
        Schema::create('tbl_user_games', function (Blueprint $table) {
            $table->id('user_game_id');
            
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
              ->references('game_id')
              ->on('tbl_games')
              ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');   

            $table->integer('rating')->nullable();
            $table->enum('status', ['played', 'playing', 'backlog', 'wishlist'])->nullable();
            $table->boolean('favorite')->default(false);
            $table->text('review')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user_games');
    }
};
