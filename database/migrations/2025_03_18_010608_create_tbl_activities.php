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
        Schema::create('tbl_activities', function (Blueprint $table) {
            $table->id('activity_id');
            $table->string('description');
            $table->enum('model_type', ['game', 'manual', 'post']);
            $table->unsignedBigInteger('model_id');
            $table->string("model_uri", 250);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_activities');
    }
};
