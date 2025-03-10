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
        Schema::table('tbl_games', function($table) {
            $table->dateTime('first_release_date')->after('coverUrl')->nullable();
            $table->float('total_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_games', function($table) {
            $table->dropColumn('first_release_date');
            $table->dropColumn('total_rating');
        });
    }
};
