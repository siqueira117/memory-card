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
        Schema::create('tbl_game_tags', function (Blueprint $table) {
            $table->id('game_tag_id');
            
            // Usuário que criou a tag
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Jogo sendo tagueado
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
                  ->references('game_id')
                  ->on('tbl_games')
                  ->onDelete('cascade');
            
            // Tag personalizada (ex: "favorito-da-infancia", "jogar-com-amigos")
            $table->string('tag', 50);
            
            $table->timestamps();
            
            // Índice para buscas rápidas
            $table->index(['user_id', 'tag']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_game_tags');
    }
};
