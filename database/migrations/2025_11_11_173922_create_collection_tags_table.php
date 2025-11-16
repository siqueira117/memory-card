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
        // Tabela de tags
        Schema::create('collection_tags', function (Blueprint $table) {
            $table->id('tag_id');
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->integer('usage_count')->default(0);
            $table->timestamps();
        });

        // Tabela pivot - relação entre coleções e tags
        Schema::create('collection_tag_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('collection_id')
                  ->references('collection_id')
                  ->on('tbl_collections')
                  ->onDelete('cascade');

            $table->foreign('tag_id')
                  ->references('tag_id')
                  ->on('collection_tags')
                  ->onDelete('cascade');

            $table->unique(['collection_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_tag_pivot');
        Schema::dropIfExists('collection_tags');
    }
};
