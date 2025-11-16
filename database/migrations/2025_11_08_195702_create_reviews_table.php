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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('tbl_games', 'game_id')->onDelete('cascade');
            $table->integer('rating')->unsigned()->comment('Nota de 1 a 5 estrelas');
            $table->text('review')->nullable()->comment('Texto do review (opcional)');
            $table->boolean('spoiler')->default(false)->comment('Marca se contém spoiler');
            $table->timestamp('played_at')->nullable()->comment('Data em que jogou');
            $table->enum('status', ['playing', 'completed', 'dropped', 'plan_to_play'])->nullable()->comment('Status do jogo');
            $table->integer('hours_played')->unsigned()->nullable()->comment('Horas jogadas');
            $table->boolean('is_edited')->default(false)->comment('Se o review foi editado');
            $table->timestamp('edited_at')->nullable()->comment('Data da última edição');
            $table->timestamps();
            
            // Índices para performance
            $table->index(['game_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('rating');
            
            // Um usuário só pode fazer um review por jogo
            $table->unique(['user_id', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
