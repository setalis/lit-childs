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
        // Создаем таблицу terms без колонки definition (если её нет)
        if (!Schema::hasTable('terms')) {
            Schema::create('terms', function (Blueprint $table) {
                $table->id();
                $table->string('name')->index();
                $table->string('image_path')->nullable();
                $table->char('first_letter', 1)->virtualAs('SUBSTRING(name, 1, 1)')->index();
                $table->timestamps();
            });
        }

        // Создаем таблицу term_definitions для множественных толкований (если её нет)
        if (!Schema::hasTable('term_definitions')) {
            Schema::create('term_definitions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('term_id')->constrained()->onDelete('cascade');
                $table->text('definition');
                $table->text('source')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_definitions');
        Schema::dropIfExists('terms');
    }
};
