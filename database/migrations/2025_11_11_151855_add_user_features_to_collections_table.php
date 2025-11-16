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
        Schema::table('tbl_collections', function (Blueprint $table) {
            // Usuário dono da coleção (nullable para coleções oficiais do sistema)
            $table->unsignedBigInteger('user_id')->nullable()->after('collection_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Descrição da coleção
            $table->text('description')->nullable()->after('slug');
            
            // Se a coleção é pública ou privada
            $table->boolean('is_public')->default(true)->after('description');
            
            // Contador de seguidores
            $table->integer('followers_count')->default(0)->after('is_public');
            
            // Contador de jogos
            $table->integer('games_count')->default(0)->after('followers_count');
            
            // Imagem de capa da coleção
            $table->string('cover_image', 255)->nullable()->after('games_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_collections', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'description',
                'is_public',
                'followers_count',
                'games_count',
                'cover_image'
            ]);
        });
    }
};
