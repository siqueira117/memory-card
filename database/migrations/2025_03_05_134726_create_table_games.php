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
        Schema::create('tbl_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->unique();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->text('summary');
            $table->text('storyline')->nullable();
            $table->string('coverUrl', 250);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_games');
    }
};
