@extends('layouts.app')

@section('title', $subsection->title . ' - Schoolbook')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500 mb-8">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4 py-8">
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

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Хлебные крошки --}}
    <nav class="mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
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
    <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-lg shadow-lg mb-8 py-8 px-6 text-white">
        <h1 class="text-3xl sm:text-4xl font-bold mb-2">{{ $subsection->title }}</h1>
        <p class="text-green-100">Розділ: {{ $subsection->section->title }}</p>
    </div>

    {{-- Навигационные кнопки --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Теоретический блок --}}
        @if($subsection->theoryBlock)
            <a href="{{ route('blocks.theory.show', $subsection) }}" class="nav-card-button button-theory">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-lg mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
            <div class="nav-card-button button-practice">
                <div class="flex items-center justify-center w-12 h-12 bg-orange-500 rounded-lg mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Практичні завдання</h3>
                <p class="text-sm text-gray-600">{{ $subsection->practiceBlocks->count() }} завдань</p>
            </div>
        @else
            <div class="nav-card-button button-practice opacity-50 cursor-not-allowed">Практичні завдання (немає)</div>
        @endif

        {{-- Самостоятельная работа --}}
        @if($subsection->homeworkBlock)
            <a href="{{ route('blocks.homework.show', $subsection) }}" class="nav-card-button button-homework">
                <div class="flex items-center justify-center w-12 h-12 bg-purple-500 rounded-lg mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 1a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
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
            <div class="nav-card-button button-control">
                <div class="flex items-center justify-center w-12 h-12 bg-red-500 rounded-lg mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Засоби перевірки</h3>
                <p class="text-sm text-gray-600">{{ $subsection->controlBlocks->count() }} блоків</p>
            </div>
        @else
            <div class="nav-card-button button-control opacity-50 cursor-not-allowed">Засоби перевірки (немає)</div>
        @endif
    </div>

    {{-- Навигационные кнопки внизу страницы --}}
    <div class="mt-8 flex flex-col sm:flex-row justify-start items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('sections.show', $subsection->section) }}" class="nav-button nav-button-secondary w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
            До змісту розділу
        </a>
        <a href="{{ route('sections.index') }}" class="nav-button nav-button-secondary w-full sm:w-auto">До змісту підручника</a>
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
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-green-700">Практичні завдання</h2>
            @foreach($subsection->practiceBlocks as $practiceBlock)
                <div class="mb-6 p-6 bg-white shadow-lg rounded-lg">
                    <h3 class="text-xl font-medium mb-2">Рівень: 
                        @if($practiceBlock->level === 'reproductive') Репродуктивний
                        @elseif($practiceBlock->level === 'constructive') Конструктивний
                        @elseif($practiceBlock->level === 'creative') Творчий
                        @endif
                    </h3>
                    @foreach($practiceBlock->elements as $element)
                        @include('pages.subsections._block_element', ['element' => $element])
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

    {{-- Задания для самостоятельной работы --}}
    @if($subsection->homeworkBlock && $subsection->homeworkBlock->elements->isNotEmpty())
        <div class="mb-8 p-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold mb-4 text-purple-700">Завдання для самостійної роботи</h2>
            @foreach($subsection->homeworkBlock->elements as $element)
                @include('pages.subsections._block_element', ['element' => $element])
            @endforeach
        </div>
    @endif

    {{-- Способы контроля --}}
    @if($subsection->controlBlocks->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-red-700">Способи контролю</h2>
            @foreach($subsection->controlBlocks as $controlBlock)
                <div class="mb-6 p-6 bg-white shadow-lg rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-medium">Засоби перевірки знань</h3>
                        <a href="{{ route('blocks.control.show', [$subsection, $controlBlock]) }}" 
                           class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors text-sm">
                            Переглянути все
                        </a>
                    </div>
                    
                    {{-- Краткий превью содержимого --}}
                    @if($controlBlock->elements->isNotEmpty())
                        <div class="mb-4 p-3 bg-blue-50 border-l-4 border-blue-500">
                            <h4 class="font-medium text-blue-800 mb-2">Питання для самоперевірки</h4>
                            <p class="text-blue-700 text-sm">
                                {{ $controlBlock->elements->count() }} {{ $controlBlock->elements->count() === 1 ? 'питання' : 'питань' }}
                            </p>
                        </div>
                    @endif
                    
                    {{-- Превью назначенного теста --}}
                    @if($controlBlock->test)
                        <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500">
                            <h4 class="font-medium text-green-800 mb-2">{{ $controlBlock->test->title }}</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">
                                    Питань: {{ $controlBlock->test->questions->count() }}
                                </span>
                                <a href="{{ route('test.show', $controlBlock->test->id) }}" 
                                   class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition-colors">
                                    Розпочати тест
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

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