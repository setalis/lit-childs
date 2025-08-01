@extends('layouts.app')

@section('title', 'Тест автоматических ссылок на персоналии')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Тест автоматических ссылок на персоналии</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Обычный текст с автоматическими ссылками</h2>
        
        <div class="prose max-w-none mb-4">
            {!! process_figure_links('Тарас Шевченко був видатним українським поетом, який зробив великий внесок у розвиток національної літератури. Разом з Іваном Франко та Лесею Українкою він становить тріаду найважливіших письменників України.') !!}
        </div>

        <div class="prose max-w-none mb-4">
            {!! process_figure_links('Микола Гоголь, незважаючи на те, що писав російською мовою, мав українське коріння. Іван Котляревський заклав основи сучасної української літератури своєю «Енеїдою».') !!}
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">HTML контент з автоматическими ссылками</h2>
        
        <div class="prose max-w-none">
            {!! process_figure_links('<p>Творчість <strong>Тараса Шевченка</strong> справила величезний вплив на українську культуру.</p><p>Його роботи, як і твори <em>Івана Франка</em>, стали класикою української літератури.</p>', true) !!}
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Blade директивы</h2>
        
        <div class="prose max-w-none mb-4">
            <h3>Директива @figureLinks:</h3>
            @figureLinks('Леся Українка була однією з найталановитіших письменниць свого часу.')
        </div>

        <div class="prose max-w-none">
            <h3>Директива @figureLinksByHtml:</h3>
            @figureLinksByHtml('<p>Між <strong>Миколою Гоголем</strong> і <em>Іваном Котляревським</em> була значна часова різниця.</p>')
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('figures.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
            Переглянути всі персоналії
        </a>
    </div>
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
@endsection 