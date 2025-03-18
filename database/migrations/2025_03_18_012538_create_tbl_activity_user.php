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
        Schema::create('tbl_activity_user', function (Blueprint $table) {
            $table->id('activity_user_id');
            $table->timestamp('read_at')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');

            $table->unsignedBigInteger('activity_id');
            $table->foreign('activity_id')
              ->references('activity_id')
              ->on('tbl_activities')
              ->onDelete('cascade');   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_activity_user');
    }
};
