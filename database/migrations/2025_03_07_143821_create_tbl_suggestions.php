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
        Schema::create('tbl_suggestions', function (Blueprint $table) {
            $table->id('suggestion_id');
            $table->string('name', 150);
            $table->string('email', 200);
            $table->enum('type', ['game', 'site']);
            $table->text('message');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_suggestions');
    }
};
