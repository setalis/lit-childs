<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Term;
use App\Models\TermDefinition;

echo "Проверяем структуру терминов...\n\n";

try {
    // Получаем все термины с их определениями
    $terms = Term::with('definitions')->get();
    
    echo "Найдено терминов: " . $terms->count() . "\n\n";
    
    foreach ($terms as $term) {
        echo "Термин: {$term->name}\n";
        echo "ID: {$term->id}\n";
        echo "Изображение: " . ($term->image_path ?? 'нет') . "\n";
        echo "Количество определений: " . $term->definitions->count() . "\n";
        
        foreach ($term->definitions as $definition) {
            echo "  - Определение: " . substr($definition->definition, 0, 100) . "...\n";
            echo "    Источник: " . ($definition->source ?? 'не указан') . "\n";
            echo "    Порядок: {$definition->sort_order}\n";
        }
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
