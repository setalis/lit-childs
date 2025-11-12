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
        Schema::table('test_match_pairs', function (Blueprint $table) {
            $table->boolean('is_distractor')->default(false)->after('right_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_match_pairs', function (Blueprint $table) {
            $table->dropColumn('is_distractor');
        });
    }
};
