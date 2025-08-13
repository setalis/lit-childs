@extends('layouts.app')

@section('title', 'Засоби перевірки - ' . $subsection->title . ' - Schoolbook')

@push('styles')
<style>
    .control-header-bg {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        padding: 4rem 0;
    }
    .test-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
        border-left: 5px solid #dc2626;
    }
    .nav-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        text-transform: uppercase;
        font-weight: 600;
        transition: background-color 0.3s ease;
        text-align: center;
    }
    .nav-button-secondary {
        background-color: #94BDDD;
        color: white;
    }
    .nav-button-secondary:hover {
        background-color: #6a8eaa;
    }
</style>
@endpush

@section('content')
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
            <li><a href="{{ route('subsections.show', $subsection) }}" class="text-[#3A6EA5] hover:underline">{{ $subsection->title }}</a></li>
            <li><span>/</span></li>
            <li class="text-gray-700" aria-current="page">Засоби перевірки</li>
        </ol>
    </nav>

    {{-- Заголовок контрольного блока --}}
    <section class="control-header-bg rounded-lg shadow-lg mb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3">
                Засоби перевірки знань
            </h1>
            <p class="text-lg sm:text-xl opacity-90">{{ $subsection->title }}</p>
        </div>
    </section>

    {{-- Контент контрольного блока --}}
    <div class="mb-8">
        {{-- Елементи контрольного блока (питання для самоперевірки) --}}
        @if($controlBlock->elements->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Питання та завдання для самоперевірки</h2>
                <div class="space-y-6">
                    @foreach($controlBlock->elements as $element)
                        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                            @include('pages.subsections._block_element', ['element' => $element])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Призначений тест --}}
        @if($controlBlock->test)
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Тестове завдання</h2>
                <div class="test-card">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $controlBlock->test->title }}</h3>
                        
                        @if($controlBlock->test->description)
                            <p class="text-gray-600 mb-4">{!! $controlBlock->test->description !!}</p>
                        @endif
                        
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex space-x-6">
                                <span class="text-sm text-gray-600">
                                    <strong>Питань:</strong> {{ $controlBlock->test->questions->count() }}
                                </span>
                                <span class="text-sm text-gray-600">
                                    <strong>Типи питань:</strong> 
                                    @php
                                        $types = $controlBlock->test->questions->pluck('type')->unique();
                                        $typeNames = [
                                            'single_choice' => 'Одиночний вибір',
                                            'multiple_choice' => 'Множинний вибір', 
                                            'fill_in_the_blank' => 'Дописування',
                                            'matching' => 'Відповідність'
                                        ];
                                        echo $types->map(fn($type) => $typeNames[$type] ?? $type)->join(', ');
                                    @endphp
                                </span>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('test.show', $controlBlock->test->id) }}" 
                               class="inline-block px-8 py-4 bg-red-600 text-white text-lg font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                Розпочати тест
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Показ всіх доступних тестів якщо немає призначеного --}}
        @if(!$controlBlock->test)
            @php
                $availableTests = \App\Models\Test::with('questions')->get();
            @endphp
            
            @if($availableTests->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Доступні тести</h2>
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($availableTests as $test)
                            <div class="test-card">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ $test->title }}</h3>
                                    
                                    @if($test->description)
                                        <p class="text-gray-600 mb-4 text-sm">{!! Str::limit($test->description, 80) !!}</p>
                                    @endif
                                    
                                    <div class="space-y-2 mb-4">
                                        <div class="flex justify-between text-sm text-gray-600">
                                            <span>Питань:</span>
                                            <span class="font-medium">{{ $test->questions->count() }}</span>
                                        </div>
                                        @if($test->questions->isNotEmpty())
                                            <div class="flex justify-between text-sm text-gray-600">
                                                <span>Типи:</span>
                                                <span class="font-medium text-xs">
                                                    @php
                                                        $types = $test->questions->pluck('type')->unique();
                                                        $typeNames = [
                                                            'single_choice' => 'Вибір',
                                                            'multiple_choice' => 'Множинний', 
                                                            'fill_in_the_blank' => 'Дописування',
                                                            'matching' => 'Відповідність'
                                                        ];
                                                        echo $types->map(fn($type) => $typeNames[$type] ?? $type)->take(2)->join(', ');
                                                        if($types->count() > 2) echo '...';
                                                    @endphp
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="text-center">
                                        <a href="{{ route('test.show', $test->id) }}" 
                                           class="inline-block w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                            Розпочати тест
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        {{-- Повідомлення якщо немає ні елементів, ні тестів --}}
        @if($controlBlock->elements->isEmpty() && !$controlBlock->test && \App\Models\Test::count() === 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Контент не знайдено</h3>
                <p class="text-yellow-700">Для цього блоку ще не додано питань для самоперевірки або тестів.</p>
            </div>
        @endif
    </div>

    {{-- Навігаційні кнопки --}}
    <div class="mt-8 flex flex-col sm:flex-row justify-start items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('subsections.show', $subsection) }}" class="nav-button nav-button-secondary w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Назад до підрозділу
        </a>
        <a href="{{ route('sections.show', $subsection->section) }}" class="nav-button nav-button-secondary w-full sm:w-auto">
            До розділу
        </a>
    </div>
</div>
@endsection 