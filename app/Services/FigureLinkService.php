<?php

namespace App\Services;

use App\Models\Figure;
use App\Models\Term;
use Illuminate\Support\Collection;

class FigureLinkService
{
    private Collection $figures;

    private Collection $terms;

    public function __construct()
    {
        $this->figures = Figure::all(['id', 'first_name', 'last_name']);
        $this->terms = Term::all(['id', 'name']);
    }

    /**
     * Генерирует варианты слова с различными окончаниями для поиска
     */
    private function generateWordVariants(string $word): array
    {
        $variants = [];
        $word = mb_strtolower(trim($word));

        // Базовое слово
        $variants[] = $word;

        // Если это составной термин (содержит пробелы), обрабатываем его по-другому
        if (strpos($word, ' ') !== false) {
            // Для составных терминов добавляем только базовую форму и возможные варианты
            $variants[] = $word; // Оригинальная форма

            // Можно добавить варианты с разными окончаниями последнего слова
            $words = explode(' ', $word);
            $lastWord = end($words);
            $baseLastWord = $this->getBaseForm($lastWord);

            if ($baseLastWord !== $lastWord) {
                $words[count($words) - 1] = $baseLastWord;
                $variants[] = implode(' ', $words);
            }

            return array_unique($variants);
        }

        // Для одиночных слов - стандартная обработка
        $base = $this->getBaseForm($word);
        if ($base !== $word) {
            $variants[] = $base;
        }

        // Добавляем варианты с различными окончаниями
        $variants = array_merge($variants, $this->getDeclensionVariants($base));

        return array_unique($variants);
    }

    /**
     * Получает базовую форму слова (убирает окончания)
     */
    private function getBaseForm(string $word): string
    {
        // Убираем типичные окончания украинского языка
        $endings = [
            // Односложные окончания
            'а', 'я', 'о', 'е', 'и', 'у', 'ю', 'ь', 'і', 'ї',
            // Двухсложные окончания
            'ого', 'ого', 'ому', 'им', 'им', 'ою', 'ою',
            'их', 'их', 'им', 'ими', 'их', 'их',
            'ий', 'ий', 'ого', 'ому', 'им', 'им', 'ий', 'ий', 'им', 'ими', 'их', 'их',
            'ая', 'ая', 'ої', 'ої', 'ою', 'ою', 'ая', 'ая', 'і', 'і', 'их', 'их', 'им', 'ими', 'их', 'их',
            'е', 'е', 'ого', 'ому', 'им', 'им', 'е', 'е', 'им', 'им', 'их', 'их',
            'і', 'і', 'ого', 'ому', 'им', 'им', 'і', 'і', 'им', 'им', 'их', 'их',
            // Трехсложные окончания
            'ого', 'ого', 'ому', 'ому', 'им', 'им', 'ою', 'ою',
            'их', 'их', 'им', 'им', 'ими', 'ими', 'их', 'их',
            // Специфические окончания для имен
            'ка', 'ка', 'ко', 'ко', 'ку', 'ку', 'ком', 'ком', 'ці', 'ці',
            'ка', 'ка', 'ки', 'ки', 'ку', 'ку', 'кою', 'кою', 'ці', 'ці',
        ];

        foreach ($endings as $ending) {
            if (mb_strlen($word) > mb_strlen($ending) && mb_substr($word, -mb_strlen($ending)) === $ending) {
                $base = mb_substr($word, 0, -mb_strlen($ending));
                if (mb_strlen($base) >= 2) { // Минимальная длина корня
                    return $base;
                }
            }
        }

        return $word;
    }

    /**
     * Генерирует варианты склонения для базовой формы
     */
    private function getDeclensionVariants(string $base): array
    {
        $variants = [];

        // Типичные окончания для различных падежей украинского языка
        $declensions = [
            // Именительный падеж (називний)
            '', 'а', 'я', 'о', 'е', 'и', 'і', 'ї',
            // Родительный падеж (родовий)
            'а', 'я', 'у', 'ю', 'і', 'ї', 'ів', 'ів', 'ей', 'ей',
            // Дательный падеж (давальний)
            'у', 'ю', 'і', 'ї', 'ам', 'ям', 'ам', 'ям',
            // Винительный падеж (знахідний)
            'а', 'я', 'у', 'ю', 'і', 'ї', 'ів', 'ів', 'ей', 'ей',
            // Творительный падеж (орудний)
            'ом', 'ем', 'ою', 'ею', 'ами', 'ями', 'ами', 'ями',
            // Предложный падеж (місцевий)
            'і', 'ї', 'ах', 'ях', 'ах', 'ях',
            // Звательный падеж (кличний)
            'е', 'е', 'у', 'ю', 'і', 'ї',
        ];

        foreach ($declensions as $ending) {
            $variant = $base.$ending;
            if (mb_strlen($variant) >= 2) {
                $variants[] = $variant;
            }
        }

        return $variants;
    }

    /**
     * Создает паттерн для поиска слова с учетом регистра и окончаний
     */
    private function createFlexiblePattern(string $word): string
    {
        $variants = $this->generateWordVariants($word);
        $patterns = [];

        foreach ($variants as $variant) {
            // Экранируем специальные символы
            $escaped = preg_quote($variant, '/');

            // Если термин состоит из нескольких слов, используем более точный паттерн
            if (strpos($variant, ' ') !== false) {
                // Для составных терминов используем границы слов только в начале и конце
                $patterns[] = '\b'.$escaped.'\b';
            } else {
                // Для одиночных слов используем границы слов
                $patterns[] = '\b'.$escaped.'\b';
            }
        }

        return '/('.implode('|', $patterns).')/ui';
    }

    /**
     * Заменяет имена персоналий в тексте на ссылки, сохраняя оригинальный текст
     *
     * @param  string|null  $context  Контекст обработки (например, 'control_block')
     */
    public function processText(string $text, ?string $context = null): string
    {
        // Пропускаем обработку для контрольных блоков
        if ($context === 'control_block') {
            return $text;
        }

        $result = $text;

        // Обрабатываем фигуры (по фамилии)
        if (! $this->figures->isEmpty()) {
            foreach ($this->figures as $figure) {
                // Ищем по фамилии
                $lastName = $figure->last_name;
                $fullName = $figure->display_name;

                if (! empty($lastName)) {
                    // Создаем гибкий паттерн для поиска
                    $pattern = $this->createFlexiblePattern($lastName);

                    // Используем callback для сохранения оригинального текста
                    $result = preg_replace_callback($pattern, function ($matches) use ($figure, $fullName) {
                        $originalText = $matches[0]; // Оригинальный текст как есть

                        return '<a href="'.route('figures.show', $figure).'" class="figure-link text-blue-600 hover:text-blue-800 underline" title="Персоналія: '.htmlspecialchars($fullName).'">'.htmlspecialchars($originalText).'</a>';
                    }, $result, 1); // Заменяем только первое вхождение
                }
            }
        }

        // Обрабатываем термины с использованием маркеров
        $result = $this->processTermsWithMarkers($result);

        return $result;
    }

    /**
     * Обрабатывает термины с использованием маркеров для предотвращения конфликтов
     */
    private function processTermsWithMarkers(string $text): string
    {
        if ($this->terms->isEmpty()) {
            return $text;
        }

        // Сортируем термины по длине (от длинных к коротким)
        $sortedTerms = $this->terms->sortByDesc(function ($term) {
            return mb_strlen($term->name);
        });

        $result = $text;
        $markerCounter = 0;
        $markers = [];

        // Сначала обрабатываем составные термины и помечаем их маркерами
        foreach ($sortedTerms as $term) {
            $termName = $term->name;

            // Если термин составной (содержит пробелы)
            if (strpos($termName, ' ') !== false) {
                $pattern = $this->createFlexiblePattern($termName);

                $result = preg_replace_callback($pattern, function ($matches) use ($term, $termName, &$markerCounter, &$markers) {
                    $originalText = $matches[0];
                    $marker = "___MARKER_{$markerCounter}___";
                    $markers[$marker] = [
                        'text' => $originalText,
                        'link' => '<a href="'.route('terms.show', $term).'" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: '.htmlspecialchars($termName).'">'.htmlspecialchars($originalText).'</a>',
                    ];
                    $markerCounter++;

                    return $marker;
                }, $result, 1);
            }
        }

        // Затем обрабатываем простые термины, но исключаем те, что уже обработаны
        foreach ($sortedTerms as $term) {
            $termName = $term->name;

            // Если термин простой (без пробелов)
            if (strpos($termName, ' ') === false) {
                $pattern = $this->createFlexiblePattern($termName);

                $result = preg_replace_callback($pattern, function ($matches) use ($term, $termName) {
                    $originalText = $matches[0];

                    return '<a href="'.route('terms.show', $term).'" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: '.htmlspecialchars($termName).'">'.htmlspecialchars($originalText).'</a>';
                }, $result, 1);
            }
        }

        // Заменяем маркеры обратно на ссылки
        foreach ($markers as $marker => $data) {
            $result = str_replace($marker, $data['link'], $result);
        }

        return $result;
    }

    /**
     * Обрабатывает HTML текст, избегая замен внутри тегов
     *
     * @param  string|null  $context  Контекст обработки (например, 'control_block')
     */
    public function processHtml(string $html, ?string $context = null): string
    {

        // Пропускаем обработку для контрольных блоков
        if ($context === 'control_block') {
            return $html;
        }

        $result = $html;

        // Обрабатываем фигуры (по фамилии)
        if (! $this->figures->isEmpty()) {
            foreach ($this->figures as $figure) {
                // Ищем по фамилии
                $lastName = $figure->last_name;
                $fullName = $figure->display_name;

                if (! empty($lastName)) {
                    // Разбиваем текст на части: текст вне тегов и сами теги
                    $parts = preg_split('/(<[^>]*>)/', $result, -1, PREG_SPLIT_DELIM_CAPTURE);

                    for ($i = 0; $i < count($parts); $i += 2) { // Обрабатываем только нечетные элементы (текст вне тегов)
                        if (isset($parts[$i])) {
                            // Создаем гибкий паттерн для поиска
                            $pattern = $this->createFlexiblePattern($lastName);

                            // Используем callback для сохранения оригинального текста
                            $parts[$i] = preg_replace_callback($pattern, function ($matches) use ($figure, $fullName) {
                                $originalText = $matches[0]; // Оригинальный текст как есть

                                return '<a href="'.route('figures.show', $figure).'" class="figure-link text-blue-600 hover:text-blue-800 underline" title="Персоналія: '.htmlspecialchars($fullName).'">'.htmlspecialchars($originalText).'</a>';
                            }, $parts[$i], 1); // Заменяем только первое вхождение
                        }
                    }

                    $result = implode('', $parts);
                }
            }
        }

        // Обрабатываем термины с использованием маркеров
        $result = $this->processTermsWithMarkersHtml($result);

        return $result;
    }

    /**
     * Обрабатывает термины в HTML с использованием маркеров для предотвращения конфликтов
     */
    private function processTermsWithMarkersHtml(string $html): string
    {
        if ($this->terms->isEmpty()) {
            return $html;
        }

        // Сортируем термины по длине (от длинных к коротким)
        $sortedTerms = $this->terms->sortByDesc(function ($term) {
            return mb_strlen($term->name);
        });

        $result = $html;
        $markerCounter = 0;
        $markers = [];

        // Сначала обрабатываем составные термины и помечаем их маркерами
        foreach ($sortedTerms as $term) {
            $termName = $term->name;

            // Если термин составной (содержит пробелы)
            if (strpos($termName, ' ') !== false) {
                // Разбиваем текст на части: текст вне тегов и сами теги
                $parts = preg_split('/(<[^>]*>)/', $result, -1, PREG_SPLIT_DELIM_CAPTURE);

                for ($i = 0; $i < count($parts); $i += 2) { // Обрабатываем только нечетные элементы (текст вне тегов)
                    if (isset($parts[$i])) {
                        $pattern = $this->createFlexiblePattern($termName);

                        $parts[$i] = preg_replace_callback($pattern, function ($matches) use ($term, $termName, &$markerCounter, &$markers) {
                            $originalText = $matches[0];
                            $marker = "___MARKER_{$markerCounter}___";
                            $markers[$marker] = [
                                'text' => $originalText,
                                'link' => '<a href="'.route('terms.show', $term).'" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: '.htmlspecialchars($termName).'">'.htmlspecialchars($originalText).'</a>',
                            ];
                            $markerCounter++;

                            return $marker;
                        }, $parts[$i], 1);
                    }
                }

                $result = implode('', $parts);
            }
        }

        // Затем обрабатываем простые термины
        foreach ($sortedTerms as $term) {
            $termName = $term->name;

            // Если термин простой (без пробелов)
            if (strpos($termName, ' ') === false) {
                // Разбиваем текст на части: текст вне тегов и сами теги
                $parts = preg_split('/(<[^>]*>)/', $result, -1, PREG_SPLIT_DELIM_CAPTURE);

                for ($i = 0; $i < count($parts); $i += 2) { // Обрабатываем только нечетные элементы (текст вне тегов)
                    if (isset($parts[$i])) {
                        $pattern = $this->createFlexiblePattern($termName);

                        $parts[$i] = preg_replace_callback($pattern, function ($matches) use ($term, $termName) {
                            $originalText = $matches[0];

                            return '<a href="'.route('terms.show', $term).'" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: '.htmlspecialchars($termName).'">'.htmlspecialchars($originalText).'</a>';
                        }, $parts[$i], 1);
                    }
                }

                $result = implode('', $parts);
            }
        }

        // Заменяем маркеры обратно на ссылки
        foreach ($markers as $marker => $data) {
            $result = str_replace($marker, $data['link'], $result);
        }

        return $result;
    }

    /**
     * Получает список всех персоналий для предпросмотра
     */
    public function getAllFigures(): Collection
    {
        return $this->figures;
    }

    /**
     * Обновляет кеш персоналий
     */
    public function refreshFigures(): void
    {
        $this->figures = Figure::all(['id', 'first_name', 'last_name']);
    }

    /**
     * Обновляет кеш терминов
     */
    public function refreshTerms(): void
    {
        $this->terms = Term::all(['id', 'name']);
    }

    /**
     * Обновляет кеш всех сущностей
     */
    public function refreshAll(): void
    {
        $this->refreshFigures();
        $this->refreshTerms();
    }
}
