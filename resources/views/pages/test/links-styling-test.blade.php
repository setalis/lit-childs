@extends('layouts.app')

@section('title', 'Тест стилізації посилань - Schoolbook')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Тест стилізації посилань</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Тест автоматических ссылок --}}
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-blue-600">Автоматичні посилання</h2>
            <div class="tinymce-content prose max-w-none">
                {!! process_figure_links('
                <p>Це тест автоматичних посилань. Тут має з\'явитися посилання на персоналію <strong>Шевченко</strong> та термін <strong>література</strong>.</p>
                <p>Також можна спробувати інші варіанти: <strong>Тарас Шевченко</strong> та <strong>літературою</strong>.</p>
                ', true) !!}
            </div>
        </div>

        {{-- Тест обычных ссылок --}}
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-green-600">Звичайні посилання</h2>
            <div class="tinymce-content prose max-w-none">
                <p>Це тест звичайних посилань, які адміністратор додає вручну:</p>
                <ul>
                    <li><a href="https://www.google.com" target="_blank">Google</a> - зовнішнє посилання</li>
                    <li><a href="{{ route('home') }}">Головна сторінка</a> - внутрішнє посилання</li>
                    <li><a href="{{ route('sections.index') }}">Зміст підручника</a> - ще одне внутрішнє посилання</li>
                </ul>
            </div>
        </div>

        {{-- Тест смешанного контента --}}
        <div class="bg-white p-6 rounded-lg shadow-lg lg:col-span-2">
            <h2 class="text-xl font-semibold mb-4 text-purple-600">Змішаний контент</h2>
            <div class="tinymce-content prose max-w-none">
                {!! process_figure_links('
                <p>Тут поєднуються автоматичні та звичайні посилання. Автоматичні посилання: <strong>Шевченко</strong> та <strong>література</strong>.</p>
                <p>А також звичайні посилання: <a href="https://www.wikipedia.org" target="_blank">Wikipedia</a> та <a href="' . route('dictionary.index') . '">Словник</a>.</p>
                <p>Всі посилання мають бути різно стилізовані:</p>
                <ul>
                    <li>🔵 <strong>Звичайні посилання</strong> - синій колір</li>
                    <li>🔴 <strong>Персоналії</strong> - синій колір з пунктирною лінією</li>
                    <li>🟢 <strong>Терміни</strong> - зелений колір з пунктирною лінією</li>
                </ul>
                ', true) !!}
            </div>
        </div>

        {{-- Тест в разных элементах --}}
        <div class="bg-white p-6 rounded-lg shadow-lg lg:col-span-2">
            <h2 class="text-xl font-semibold mb-4 text-orange-600">Посилання в різних елементах</h2>
            
            {{-- Кнопки --}}
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-3">Кнопки:</h3>
                <div class="space-x-4">
                    <a href="https://www.example.com" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Звичайна кнопка</a>
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Внутрішня кнопка</a>
                </div>
            </div>

            {{-- Списки --}}
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-3">Списки:</h3>
                <ul class="list-disc list-inside space-y-2">
                    <li><a href="https://www.github.com">GitHub</a> - платформа для розробників</li>
                    <li><a href="https://www.stackoverflow.com">Stack Overflow</a> - спільнота програмістів</li>
                    <li><a href="{{ route('figures.index') }}">Персоналії</a> - список персоналій</li>
                </ul>
            </div>

            {{-- Таблицы --}}
            <div>
                <h3 class="text-lg font-medium mb-3">Таблиця:</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Назва</th>
                            <th class="border border-gray-300 px-4 py-2">Посилання</th>
                            <th class="border border-gray-300 px-4 py-2">Опис</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Google</td>
                            <td class="border border-gray-300 px-4 py-2"><a href="https://www.google.com">google.com</a></td>
                            <td class="border border-gray-300 px-4 py-2">Пошукова система</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Головна</td>
                            <td class="border border-gray-300 px-4 py-2"><a href="{{ route('home') }}">Головна сторінка</a></td>
                            <td class="border border-gray-300 px-4 py-2">Внутрішнє посилання</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Инструкции --}}
    <div class="mt-8 bg-blue-50 p-6 rounded-lg">
        <h3 class="text-lg font-semibold mb-3 text-blue-800">Інструкції для тестування:</h3>
        <ul class="list-disc list-inside space-y-2 text-blue-700">
            <li><strong>Автоматичні посилання</strong> мають з'явитися автоматично для слів "Шевченко" та "література"</li>
            <li><strong>Звичайні посилання</strong> мають бути синіми з підкресленням</li>
            <li><strong>При наведенні</strong> на автоматичні посилання має з'явитися підказка</li>
            <li><strong>При наведенні</strong> на звичайні посилання має з'явитися фоновий колір</li>
        </ul>
    </div>
</div>
@endsection 