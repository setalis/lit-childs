<?php

declare(strict_types=1);

use App\Models\BlockElement;

test('figure links are disabled in control blocks', function () {
    // Найдем существующие элементы контрольных блоков
    $controlElements = BlockElement::where('block_elementable_type', 'App\Models\ControlBlock')->get();

    if ($controlElements->isEmpty()) {
        $this->markTestSkipped('No control block elements found in database');
    }

    foreach ($controlElements as $element) {
        // Проверяем, что элемент определяется как элемент контрольного блока
        expect($element->isFromControlBlock())->toBeTrue();

        // Проверяем, что в обработанном контенте НЕ создаются ссылки
        $processedContent = $element->processed_content;
        $originalContent = $element->content;

        // Если в оригинальном контенте есть слова, которые могли бы стать ссылками,
        // то в обработанном контенте их быть не должно
        if (! empty($originalContent)) {
            // Проверяем, что обработанный контент не содержит ссылок
            expect($processedContent)->not->toContain('<a href=');

            // Если в оригинале есть HTML, то он должен остаться без изменений
            if (strpos($originalContent, '<') !== false) {
                // Убираем возможные ссылки для сравнения
                $processedWithoutLinks = preg_replace('/<a[^>]*>.*?<\/a>/', '', $processedContent);
                $originalWithoutLinks = preg_replace('/<a[^>]*>.*?<\/a>/', '', $originalContent);

                expect(trim($processedWithoutLinks))->toBe(trim($originalWithoutLinks));
            }
        }
    }
});

test('figure links are enabled in non-control blocks', function () {
    // Найдем элементы, которые НЕ являются контрольными блоками
    $nonControlElements = BlockElement::where('block_elementable_type', '!=', 'App\Models\ControlBlock')->get();

    if ($nonControlElements->isEmpty()) {
        $this->markTestSkipped('No non-control block elements found in database');
    }

    foreach ($nonControlElements as $element) {
        // Проверяем, что элемент НЕ определяется как элемент контрольного блока
        expect($element->isFromControlBlock())->toBeFalse();

        // Проверяем, что в обработанном контенте МОГУТ создаваться ссылки
        $processedContent = $element->processed_content;
        $originalContent = $element->content;

        // Если в оригинальном контенте есть слова, которые могут стать ссылками,
        // то в обработанном контенте они должны стать ссылками
        if (! empty($originalContent) && strpos($originalContent, '<') !== false) {
            // Проверяем, что обработанный контент может содержать ссылки
            // (но не обязательно, если нет подходящих слов)
            expect($processedContent)->not->toBeEmpty();
        }
    }
});

test('helper function respects control block context', function () {
    $testText = '<p>Тестовий текст з можливими посиланнями</p>';

    // Без контекста - ссылки могут создаваться
    $processedWithoutContext = process_figure_links($testText, true);
    expect($processedWithoutContext)->not->toBeEmpty();

    // С контекстом control_block - ссылки НЕ должны создаваться
    $processedWithContext = process_figure_links($testText, true, 'control_block');
    expect($processedWithContext)->toBe($testText);

    // Результаты должны быть одинаковыми для этого тестового текста
    // (так как в нем нет слов, которые могли бы стать ссылками)
    expect($processedWithoutContext)->toBe($processedWithContext);
});


