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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable()->index();
            $table->text('biography');
            $table->text('sources')->nullable();
            $table->text('biography_2')->nullable();
            $table->text('sources_2')->nullable();
            $table->string('image_path')->nullable();
            $table->char('first_letter', 1)->virtualAs('UPPER(SUBSTRING(last_name, 1, 1))')->index();
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
