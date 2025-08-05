@extends('layouts.app')

@section('title', $subsection->title . ' - Schoolbook')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Розділ {{ $subsection->order }}</h1>
            <h2 class="text-3xl font-bold mb-4 uppercase">{{ $subsection->title }}</h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-8 pt-4">
    {{-- Хлебные крошки --}}
    <nav class="mb-16 text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex space-x-2">
            <li><a href="{{ route('home') }}" class="text-[#3A6EA5] hover:underline">Головна</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('sections.index') }}" class="text-[#3A6EA5] hover:underline">Зміст</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('sections.show', $subsection->section) }}" class="text-[#3A6EA5] hover:underline">{{ $subsection->section->title }}</a></li>
            <li><span>/</span></li>
            <li class="text-gray-700" aria-current="page">{{ $subsection->title }}</li>
        </ol>
    </nav>

    {{-- Заголовок подраздела --}}
    <!-- <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-lg shadow-lg mb-8 py-8 px-6 text-white">
        <h1 class="text-3xl sm:text-4xl font-bold mb-2">{{ $subsection->title }}</h1>
        <p class="text-green-100">Розділ: {{ $subsection->section->title }}</p>
    </div> -->

    {{-- Навигационные кнопки --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Теоретический блок --}}
        @if($subsection->theoryBlock)
            <a href="{{ route('blocks.theory.show', $subsection) }}" class="nav-card-button button-theory">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" class="bi bi-card-heading" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                    <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
                </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Теоретичний матеріал</h3>
                <p class="text-sm text-gray-600">Основні поняття та концепції</p>
            </a>
        @else
            <div class="nav-card-button button-theory opacity-50 cursor-not-allowed">Теоретичний матеріал (немає)</div>
        @endif

        {{-- Практические задания --}}
        @if($subsection->practiceBlocks->isNotEmpty())
            <a href="{{ route('blocks.practice.all', $subsection) }}" class="nav-card-button button-practice">
                <div class="flex items-center justify-center w-12 h-12 bg-orange-500 rounded-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" class="bi bi-card-text" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                        <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8m0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
                </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Практичні завдання</h3>
                <p class="text-sm text-gray-600">{{ $subsection->practiceBlocks->count() }} завдань</p>
            </a>
        @else
            <div class="nav-card-button button-practice opacity-50 cursor-not-allowed">Практичні завдання (немає)</div>
        @endif

        {{-- Самостоятельная работа --}}
        @if($subsection->homeworkBlock)
            <a href="{{ route('blocks.homework.show', $subsection) }}" class="nav-card-button button-homework">
                <div class="flex items-center justify-center w-12 h-12 bg-purple-500 rounded-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" class="bi bi-card-list" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                    <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Самостійна робота</h3>
                <p class="text-sm text-gray-600">Завдання для виконання</p>
            </a>
        @else
            <div class="nav-card-button button-homework opacity-50 cursor-not-allowed">Самостійна робота (немає)</div>
        @endif

        {{-- Контроль знаний --}}
        @if($subsection->controlBlocks->isNotEmpty())
        <a href="{{ route('blocks.control.all', $subsection) }}" class="nav-card-button button-control">
            <div class="nav-card-button button-control">
                <div class="flex items-center justify-center w-12 h-12 bg-red-500 rounded-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" class="bi bi-card-checklist" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Засоби перевірки</h3>
                <p class="text-sm text-gray-600">{{ $subsection->controlBlocks->count() }} блоків</p>
            </div>
        </a>
        @else
            <div class="nav-card-button button-control opacity-50 cursor-not-allowed">Засоби перевірки (немає)</div>
        @endif
    </div>    

    {{-- Теоретический блок --}}
    @if($subsection->theoryBlock && $subsection->theoryBlock->elements->isNotEmpty())
        <div class="mb-8 p-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold mb-4 text-blue-700">Теоретичний матеріал</h2>
            @foreach($subsection->theoryBlock->elements as $element)
                @include('pages.subsections._block_element', ['element' => $element])
            @endforeach
        </div>
    @endif

    {{-- Практические задания --}}
    @if($subsection->practiceBlocks->isNotEmpty())
        <div class="mb-8 p-6 bg-white shadow-lg rounded-lg">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-green-700">Практичні завдання</h2>
                <a href="{{ route('blocks.practice.all', $subsection) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors text-sm">
                    Переглянути всі
                </a>
            </div>
            <p class="text-gray-600 mb-4">Доступні рівні складності: 
                @php
                    $levels = $subsection->practiceBlocks->pluck('level')->unique();
                    $levelNames = $levels->map(function($level) {
                        return match($level) {
                            'reproductive' => 'Репродуктивний',
                            'constructive' => 'Конструктивний', 
                            'creative' => 'Творчий',
                            default => ucfirst($level)
                        };
                    })->join(', ');
                @endphp
                {{ $levelNames }}
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($subsection->practiceBlocks->take(3) as $practiceBlock)
                    <a href="{{ route('blocks.practice.show', [$subsection, $practiceBlock]) }}" 
                       class="block p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200">
                        <h3 class="font-medium text-gray-800 mb-2">
                            Практичне завдання №{{ $practiceBlock->order }}
                        </h3>
                        <div class="flex flex-row items-center justify-between ">
                            <p class="text-sm text-gray-600 font-semibold">Рівень: </p>
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded                        
                            @if($practiceBlock->level === 'reproductive') bg-green-100 text-green-800
                            @elseif($practiceBlock->level === 'constructive') bg-yellow-100 text-yellow-800
                            @elseif($practiceBlock->level === 'creative') bg-red-100 text-red-800
                            @endif">
                            @if($practiceBlock->level === 'reproductive') Репродуктивний
                            @elseif($practiceBlock->level === 'constructive') Конструктивний
                            @elseif($practiceBlock->level === 'creative') Творчий
                            @endif
                        </span></div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Задания для самостоятельной работы --}}
    @if($subsection->homeworkBlock && $subsection->homeworkBlock->elements->isNotEmpty())
        <div class="mb-8 p-6 bg-white shadow-lg rounded-lg">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold mb-4 text-purple-700">Завдання для самостійної роботи</h2>
                <a href="{{ route('blocks.homework.show', $subsection) }}" 
                   class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors text-sm">
                    Переглянути всі
                </a>
            </div>
            
            @foreach($subsection->homeworkBlock->elements as $element)
                @include('pages.subsections._block_element', ['element' => $element])
            @endforeach
        </div>
    @endif

    {{-- Способы контроля --}}
    @if($subsection->controlBlocks->isNotEmpty())
        <div class="mb-8 p-6 bg-white shadow-lg rounded-lg">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-red-700">Способи контролю</h2>
                <a href="{{ route('blocks.control.all', $subsection) }}" 
                   class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors text-sm">
                    Переглянути всі
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($subsection->controlBlocks as $controlBlock)
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-medium text-gray-800">Засоби перевірки знань</h3>
                            <a href="{{ route('blocks.control.show', [$subsection, $controlBlock]) }}" 
                               class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-colors text-xs">
                                Переглянути
                            </a>
                        </div>
                        
                        {{-- Краткий превью содержимого --}}
                        @if($controlBlock->elements->isNotEmpty())
                            <div class="mb-3 p-2 bg-blue-50 border-l-3 border-blue-500 rounded-r">
                                <h4 class="font-medium text-blue-800 text-sm mb-1">Питання для самоперевірки</h4>
                                <p class="text-blue-700 text-xs">
                                    {{ $controlBlock->elements->count() }} {{ $controlBlock->elements->count() === 1 ? 'питання' : 'питань' }}
                                </p>
                            </div>
                        @endif
                        
                        {{-- Превью назначенного теста --}}
                        @if($controlBlock->test)
                            <div class="p-2 bg-green-50 border-l-3 border-green-500 rounded-r">
                                <h4 class="font-medium text-green-800 text-sm mb-1">{{ $controlBlock->test->title }}</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700">
                                        Питань: {{ $controlBlock->test->questions->count() }}
                                    </span>
                                    <a href="{{ route('test.show', $controlBlock->test->id) }}" 
                                       class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700 transition-colors">
                                        Розпочати
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Навигационные кнопки внизу страницы --}}
    <div class="mt-8 flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('sections.show', $subsection->section) }}" class="w-full sm:w-auto border font-semibold border-yellow-500 bg-yellow-500 px-4 py-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
            До змісту розділу
        </a>
        <a href="{{ route('sections.index') }}" class="nav-button nav-button-secondary w-full sm:w-auto px-4 py-3 border border-[#94BDDD] rounded-full">До змісту підручника</a>
    </div>

</div>
@endsection 

<style>
.nav-card-button {
    @apply bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 text-center block;
}

.button-theory:hover {
    @apply bg-blue-50;
}

.button-practice:hover {
    @apply bg-orange-50;
}

.button-homework:hover {
    @apply bg-purple-50;
}

.button-control:hover {
    @apply bg-red-50;
}

.nav-button {
    @apply inline-flex items-center px-4 py-2 rounded-lg font-medium transition-colors;
}

.nav-button-secondary {
    @apply bg-gray-600 text-white hover:bg-gray-700;
}
</style> 