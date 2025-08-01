{{-- Пример использования автоматических ссылок на персоналии --}}

@props(['content' => '', 'isHtml' => false])

<div class="figure-links-content">
    @if($isHtml)
        {{-- Для HTML контента --}}
        {!! @figureLinksByHtml($content) !!}
    @else
        {{-- Для обычного текста --}}
        {!! @figureLinks($content) !!}
    @endif
</div>

{{-- Стили для ссылок на персоналии --}}
<style>
.figure-link {
    position: relative;
    text-decoration: underline;
    text-decoration-style: dotted;
}

.figure-link:hover {
    text-decoration-style: solid;
}

.figure-link:hover::after {
    content: "Перейти к персоналии";
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
    pointer-events: none;
}
</style> 