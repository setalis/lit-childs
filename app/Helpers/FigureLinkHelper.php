<?php

if (!function_exists('process_figure_links')) {
    /**
     * Обрабатывает текст, добавляя ссылки на персоналии
     *
     * @param string $text
     * @param bool $isHtml
     * @return string
     */
    function process_figure_links(string $text, bool $isHtml = false): string
    {
        $service = app(\App\Services\FigureLinkService::class);
        
        if ($isHtml) {
            return $service->processHtml($text);
        }
        
        return $service->processText($text);
    }
}

if (!function_exists('get_all_figures')) {
    /**
     * Получает все персоналии для предпросмотра
     *
     * @return \Illuminate\Support\Collection
     */
    function get_all_figures(): \Illuminate\Support\Collection
    {
        $service = app(\App\Services\FigureLinkService::class);
        return $service->getAllFigures();
    }
} 