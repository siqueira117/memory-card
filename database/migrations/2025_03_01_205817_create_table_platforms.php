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
        Schema::create('tbl_platforms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('platform_id')->unique();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->integer('generation')->nullable();
            $table->string('abbreviation', 150)->nullable();
            $table->string('alternative_name', 250)->nullable();
            $table->longText('summary')->nullable();
            
            $table->foreignId('platform_type_id')->nullable();
            $table->foreign('platform_type_id')->references('platform_type_id')->on('tbl_platform_types');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_platforms');
    }
};
