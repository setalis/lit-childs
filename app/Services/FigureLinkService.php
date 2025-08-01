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
     * Заменяет имена персоналий в тексте на ссылки
     *
     * @param string $text
     * @return string
     */
        public function processText(string $text): string
    {
        // Создаем массив для замен
        $replacements = [];
        
        // Обрабатываем фигуры (по фамилии)
        if (!$this->figures->isEmpty()) {
            foreach ($this->figures as $figure) {
                // Ищем по фамилии
                $lastName = $figure->last_name ?: explode(' ', $figure->name)[count(explode(' ', $figure->name)) - 1];
                $fullName = $figure->display_name ?: $figure->name;
                
                if (!empty($lastName)) {
                    $figureLink = '<a href="' . route('figures.show', $figure) . '" class="figure-link text-blue-600 hover:text-blue-800 underline" title="Персоналія: ' . htmlspecialchars($fullName) . '">' . htmlspecialchars($lastName) . '</a>';
                    
                    // Ищем точные совпадения фамилии (с учетом границ слов)
                    $pattern = '/\b' . preg_quote($lastName, '/') . '\b/u';
                    
                    // Проверяем, есть ли совпадения в тексте
                    if (preg_match($pattern, $text)) {
                        $replacements[$pattern] = $figureLink;
                    }
                }
            }
        }
        
        // Обрабатываем термины
        if (!$this->terms->isEmpty()) {
            foreach ($this->terms as $term) {
                $termName = $term->name;
                $termLink = '<a href="' . route('terms.show', $term) . '" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: ' . htmlspecialchars($termName) . '">' . htmlspecialchars($termName) . '</a>';
                
                // Ищем точные совпадения термина (с учетом границ слов)
                $pattern = '/\b' . preg_quote($termName, '/') . '\b/u';
                
                // Проверяем, есть ли совпадения в тексте
                if (preg_match($pattern, $text)) {
                    $replacements[$pattern] = $termLink;
                }
            }
        }

        // Применяем замены
        foreach ($replacements as $pattern => $replacement) {
            $text = preg_replace($pattern, $replacement, $text, 1); // Заменяем только первое вхождение
        }

        return $text;
    }

    /**
     * Обрабатывает HTML текст, избегая замен внутри тегов
     *
     * @param string $html
     * @return string
     */
        public function processHtml(string $html): string
    {
        // Используем более простой подход - разбиваем на части по тегам
        $result = $html;
        
        // Обрабатываем фигуры (по фамилии)
        if (!$this->figures->isEmpty()) {
            foreach ($this->figures as $figure) {
                // Ищем по фамилии
                $lastName = $figure->last_name ?: explode(' ', $figure->name)[count(explode(' ', $figure->name)) - 1];
                $fullName = $figure->display_name ?: $figure->name;
                
                if (!empty($lastName)) {
                    $figureLink = '<a href="' . route('figures.show', $figure) . '" class="figure-link text-blue-600 hover:text-blue-800 underline" title="Персоналія: ' . htmlspecialchars($fullName) . '">' . htmlspecialchars($lastName) . '</a>';
                    
                    // Разбиваем текст на части: текст вне тегов и сами теги
                    $parts = preg_split('/(<[^>]*>)/', $result, -1, PREG_SPLIT_DELIM_CAPTURE);
                    
                    for ($i = 0; $i < count($parts); $i += 2) { // Обрабатываем только нечетные элементы (текст вне тегов)
                        if (isset($parts[$i])) {
                            // Применяем замену только к тексту вне тегов
                            $pattern = '/\b' . preg_quote($lastName, '/') . '\b/u';
                            $parts[$i] = preg_replace($pattern, $figureLink, $parts[$i], 1);
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
                $termLink = '<a href="' . route('terms.show', $term) . '" class="term-link text-green-600 hover:text-green-800 underline" title="Термін: ' . htmlspecialchars($termName) . '">' . htmlspecialchars($termName) . '</a>';
                
                // Разбиваем текст на части: текст вне тегов и сами теги
                $parts = preg_split('/(<[^>]*>)/', $result, -1, PREG_SPLIT_DELIM_CAPTURE);
                
                for ($i = 0; $i < count($parts); $i += 2) { // Обрабатываем только нечетные элементы (текст вне тегов)
                    if (isset($parts[$i])) {
                        // Применяем замену только к тексту вне тегов
                        $pattern = '/\b' . preg_quote($termName, '/') . '\b/u';
                        $parts[$i] = preg_replace($pattern, $termLink, $parts[$i], 1);
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