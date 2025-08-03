@extends('layouts.app')

@section('title', 'Тест термінів - Schoolbook')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Тест автоматичних посилань на терміни</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Тест составных терминов --}}
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-blue-600">Складні терміни</h2>
            <div class="tinymce-content prose max-w-none">
                {!! process_figure_links('
                <p>Тут тестуємо складні терміни:</p>
                <ul>
                    <li>світова література - має стати посиланням на складний термін</li>
                    <li>українська література - має стати посиланням на складний термін</li>
                    <li>література - має стати посиланням на простий термін</li>
                </ul>
                <p>Також тестуємо в контексті: "У світовій літературі є багато шедеврів, а українська література має свої особливості."</p>
                ', true) !!}
            </div>
        </div>

        {{-- Тест простых терминов --}}
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-green-600">Прості терміни</h2>
            <div class="tinymce-content prose max-w-none">
                {!! process_figure_links('
                <p>Тут тестуємо прості терміни:</p>
                <ul>
                    <li>література - простий термін</li>
                    <li>поема - простий термін</li>
                    <li>роман - простий термін</li>
                </ul>
                <p>Також тестуємо в контексті: "Література включає поеми та романи."</p>
                ', true) !!}
            </div>
        </div>

        {{-- Тест ключевых слов --}}
        <div class="bg-white p-6 rounded-lg shadow-lg lg:col-span-2">
            <h2 class="text-xl font-semibold mb-4 text-purple-600">Ключові слова</h2>
            <div class="tinymce-content prose max-w-none">
                <p>Тестуємо ключові слова з автоматичними посиланнями:</p>
                
                <div class="mt-2 border border-yellow-500 p-6 pb-4 rounded-2xl">
                    <span class="font-semibold">Ключові слова:</span>
                    @php
                        $keywords = ['світова література', 'українська література', 'література', 'поема', 'роман'];
                    @endphp
                    @foreach($keywords as $keyword)
                        <span class="inline-block py-1 text-base font-light text-gray-700 mr-1">
                            {!! process_figure_links($keyword, true) !!},
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Инструкции --}}
    <div class="mt-8 bg-blue-50 p-6 rounded-lg">
        <h3 class="text-lg font-semibold mb-3 text-blue-800">Інструкції для тестування:</h3>
        <ul class="list-disc list-inside space-y-2 text-blue-700">
            <li><strong>Складні терміни</strong> (світова література, українська література) мають стати посиланнями на повні терміни</li>
            <li><strong>Прості терміни</strong> (література, поема, роман) мають стати посиланнями на окремі терміни</li>
            <li><strong>Ключові слова</strong> мають автоматично стати посиланнями</li>
            <li><strong>При наведенні</strong> на посилання має з'явитися підказка з назвою терміну</li>
        </ul>
    </div>
</div>
@endsection 