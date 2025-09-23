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
        // Исправляем записи ключевых слов, которые сохранены как обычные строки
        $elements = \App\Models\BlockElement::where('element_type', 'keywords')->get();
        
        foreach ($elements as $element) {
            $content = $element->content;
            
            // Проверяем, является ли контент JSON-массивом
            $decoded = json_decode($content, true);
            
            // Если это не JSON-массив, конвертируем строку в массив
            if (!is_array($decoded)) {
                // Разделяем по запятым и очищаем от пробелов
                $keywords = array_filter(array_map('trim', explode(',', $content)));
                
                // Сохраняем как JSON-массив
                $element->update([
                    'content' => json_encode($keywords, JSON_UNESCAPED_UNICODE)
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
