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
        Schema::create('block_elements', function (Blueprint $table) {
            $table->id();
            $table->morphs('block_elementable');
            $table->enum('element_type', ['text', 'keywords', 'image', 'gallery', 'button_group']);
            $table->longText('content');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_elements');
    }
};
