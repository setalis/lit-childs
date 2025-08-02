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
        $this->figures = Figure::all(['id', 'name', 'first_name', 'last_name']);
        $this->terms = Term::all(['id', 'name']);
    }

    /**
     * Генерирует варианты слова с различными окончаниями для поиска
     *
     * @param string $word
     * @return array
     */
    private function generateWordVariants(string $word): array
    {
        $variants = [];
        $word = mb_strtolower(trim($word));
        
        // Базовое слово
        $variants[] = $word;
        
        // Убираем возможные окончания и добавляем варианты
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
     *
     * @param string $word
     * @return string
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
            'ка', 'ка', 'ки', 'ки', 'ку', 'ку', 'кою', 'кою', 'ці', 'ці'
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
     *
     * @param string $base
     * @return array
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
            'е', 'е', 'у', 'ю', 'і', 'ї'
        ];
        
        foreach ($declensions as $ending) {
            $variant = $base . $ending;
            if (mb_strlen($variant) >= 2) {
                $variants[] = $variant;
            }
        }
        
        return $variants;
    }

    /**
     * Создает паттерн для поиска слова с учетом регистра и окончаний
     *
     * @param string $word
     * @return string
     */
    private function createFlexiblePattern(string $word): string
    {
        $variants = $this->generateWordVariants($word);
        $patterns = [];
        
        foreach ($variants as $variant) {
            // Экранируем специальные символы
            $escaped = preg_quote($variant, '/');
            // Создаем паттерн с границами слов и игнорированием регистра
            $patterns[] = '\b' . $escaped . '\b';
        }
        
        return '/(' . implode('|', $patterns) . ')/ui';
    }

    /**
     * Заменяет имена персоналий в тексте на ссылки, сохраняя оригинальный текст
     *
     * @param string $text
     * @return string
     */
    public function processText(string $text): string
    {
        $result = $text;
        
        // Обрабатываем фигуры (по фамилии)
        if (!$this->figures->isEmpty()) {
            foreach ($this->figures as $figure) {
                // Ищем по фамилии
                $lastName = $figure->last_name ?: explode(' ', $figure->name)[count(explode(' ', $figure->name)) - 1];
                $fullName = $figure->display_name ?: $figure->name;
                
                if (!empty($lastName)) {
                    // Создаем гибкий паттерн для поиска
                    $pattern = $this->createFlexiblePattern($lastName);
                    
                    // Используем callback для сохранения оригинального текста
                    $result = preg_replace_callback($pattern, function($matches) use ($figure, $fullName) {
                        $originalText = $matches[0]; // Оригинальный текст как есть
                        return '<a href="' . route('figures.show', $figure) . '" class="figure-link text-blue-600 hover:text-blue-800 underline" title="Персоналія: ' . htmlspecialchars($fullName) . '">' . htmlspecialchars($originalText) . '</a>';
                    }, $result, 1); // Заменяем только первое вхождение
                }
            }
        }
        
        // Обрабатываем термины
        if (!$this->terms->isEmpty()) {
            foreach ($this->terms as $term) {
                $termName = $term->name;
                
                // Создаем гибкий паттерн для поиска
                $pattern = $this->createFlexiblePattern($termName);
                
                // Используем callback для сохранения оригинального текста
                $result = preg_replace_callback($pattern, function($matches) use ($term, $termName) {
                    $originalText = $matches[0]; // Оригинальный текст как есть
                    return '<a href="' . route('terms.show', $term) . '" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: ' . htmlspecialchars($termName) . '">' . htmlspecialchars($originalText) . '</a>';
                }, $result, 1); // Заменяем только первое вхождение
            }
        }

        return $result;
    }

    /**
     * Обрабатывает HTML текст, избегая замен внутри тегов
     *
     * @param string $html
     * @return string
     */
    public function processHtml(string $html): string
    {
        $result = $html;
        
        // Обрабатываем фигуры (по фамилии)
        if (!$this->figures->isEmpty()) {
            foreach ($this->figures as $figure) {
                // Ищем по фамилии
                $lastName = $figure->last_name ?: explode(' ', $figure->name)[count(explode(' ', $figure->name)) - 1];
                $fullName = $figure->display_name ?: $figure->name;
                
                if (!empty($lastName)) {
                    // Разбиваем текст на части: текст вне тегов и сами теги
                    $parts = preg_split('/(<[^>]*>)/', $result, -1, PREG_SPLIT_DELIM_CAPTURE);
                    
                    for ($i = 0; $i < count($parts); $i += 2) { // Обрабатываем только нечетные элементы (текст вне тегов)
                        if (isset($parts[$i])) {
                            // Создаем гибкий паттерн для поиска
                            $pattern = $this->createFlexiblePattern($lastName);
                            
                            // Используем callback для сохранения оригинального текста
                            $parts[$i] = preg_replace_callback($pattern, function($matches) use ($figure, $fullName) {
                                $originalText = $matches[0]; // Оригинальный текст как есть
                                return '<a href="' . route('figures.show', $figure) . '" class="figure-link text-blue-600 hover:text-blue-800 underline" title="Персоналія: ' . htmlspecialchars($fullName) . '">' . htmlspecialchars($originalText) . '</a>';
                            }, $parts[$i], 1); // Заменяем только первое вхождение
                        }
                    }
                    
                    $result = implode('', $parts);
                }
            }
        }
        
        // Обрабатываем термины
        if (!$this->terms->isEmpty()) {
            foreach ($this->terms as $term) {
                $termName = $term->name;
                
                // Разбиваем текст на части: текст вне тегов и сами теги
                $parts = preg_split('/(<[^>]*>)/', $result, -1, PREG_SPLIT_DELIM_CAPTURE);
                
                for ($i = 0; $i < count($parts); $i += 2) { // Обрабатываем только нечетные элементы (текст вне тегов)
                    if (isset($parts[$i])) {
                        // Создаем гибкий паттерн для поиска
                        $pattern = $this->createFlexiblePattern($termName);
                        
                        // Используем callback для сохранения оригинального текста
                        $parts[$i] = preg_replace_callback($pattern, function($matches) use ($term, $termName) {
                            $originalText = $matches[0]; // Оригинальный текст как есть
                            return '<a href="' . route('terms.show', $term) . '" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: ' . htmlspecialchars($termName) . '">' . htmlspecialchars($originalText) . '</a>';
                        }, $parts[$i], 1); // Заменяем только первое вхождение
                    }
                }
                
                $result = implode('', $parts);
            }
        }

        return $result;
    }

    /**
     * Получает список всех персоналий для предпросмотра
     *
     * @return Collection
     */
    public function getAllFigures(): Collection
    {
        return $this->figures;
    }

    /**
     * Обновляет кеш персоналий
     *
     * @return void
     */
    public function refreshFigures(): void
    {
        $this->figures = Figure::all(['id', 'name', 'first_name', 'last_name']);
    }

    /**
     * Обновляет кеш терминов
     *
     * @return void
     */
    public function refreshTerms(): void
    {
        $this->terms = Term::all(['id', 'name']);
    }

    /**
     * Обновляет кеш всех сущностей
     *
     * @return void
     */
    public function refreshAll(): void
    {
        $this->refreshFigures();
        $this->refreshTerms();
    }
} 