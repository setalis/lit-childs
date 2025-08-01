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
        Schema::create('control_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subsection_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_id')->nullable()->constrained('tests')->nullOnDelete();
            $table->string('type')->default('test'); // 'test' або 'questions'
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_blocks');
    }
};
