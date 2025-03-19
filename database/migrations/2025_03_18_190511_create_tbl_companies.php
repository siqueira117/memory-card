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
        Schema::create('tbl_companies', function (Blueprint $table) {
            $table->id('company_id');
            $table->string('name', 200);
            $table->string('slug', 200);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'defunct', 'merged', 'renamed']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_companies');
    }
};
