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
        Schema::create('tbl_game_companies', function (Blueprint $table) {
            $table->id('game_company_id');
            
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
              ->references('game_id')
              ->on('tbl_games')
              ->onDelete('cascade');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
              ->references('company_id')
              ->on('tbl_companies')
              ->onDelete('cascade');   

            $table->boolean('developer');
            $table->boolean('porting');
            $table->boolean('publisher');
            $table->boolean('supporting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_game_companies');
    }
};
