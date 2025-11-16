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
        Schema::create('tbl_collection_followers', function (Blueprint $table) {
            $table->id('collection_follower_id');
            
            // Usuário que está seguindo
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Coleção sendo seguida
            $table->unsignedBigInteger('collection_id');
            $table->foreign('collection_id')
                  ->references('collection_id')
                  ->on('tbl_collections')
                  ->onDelete('cascade');
            
            $table->timestamps();
            
            // Evitar que um usuário siga a mesma coleção múltiplas vezes
            $table->unique(['user_id', 'collection_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_collection_followers');
    }
};
