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
        Schema::create('figures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->text('biography');
            $table->string('image_path')->nullable();
            $table->char('first_letter', 1)->virtualAs('SUBSTRING(COALESCE(NULLIF(last_name, ""), name), 1, 1)')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figures');
    }
};
