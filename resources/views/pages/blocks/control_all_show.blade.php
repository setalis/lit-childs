@extends('layouts.app')

@section('title', $subsection->title . ' - Способи контролю - Schoolbook')

@push('styles')
<style>
    .block-content-bg {
        background-image: url("{{ asset('images/main-bg-1-1.png') }}"); 
        background-size: cover;
        background-position: center;
        color: white; 
    }
    .content-card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
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
    .nav-button-primary {
        background-color: #FEC200; 
        color: #212529;
    }
    .nav-button-primary:hover {
        background-color: #e0a800; 
    }
    .nav-button-secondary {
        background-color: #94BDDD; 
        color: white;
    }
    .nav-button-secondary:hover {
        background-color: #6a8eaa; 
    }
    .control-section {
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .control-section-header {
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 1.125rem;
        color: white;
        background-color: #dc3545;
    }
    .control-section-content {
        padding: 1.5rem;
        background-color: #ffffff;
    }
</style>
@endpush

@section('content')
{{-- Заголовок блока с фоном --}}
<div class="flex flex-col items-center justify-center border-b border-yellow-500">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 text-[#28569A]">Способи контролю</h1>
            <h2 class="text-2xl font-semibold mb-2 text-gray-700">{{ $subsection->section->order }}.{{ $subsection->order }} {{ $subsection->title }}</h2>
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
            <li><a href="{{ route('subsections.show', $subsection) }}" class="text-[#3A6EA5] hover:underline">{{ $subsection->title }}</a></li>
            <li><span>/</span></li>
            <li class="text-gray-700" aria-current="page">Способи контролю</li>
        </ol>
    </nav>

    @if($controlBlocks->isEmpty())
        <div class="content-card text-center">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Способи контролю відсутні</h3>
            <p class="text-gray-600">Для цього розділу поки що не створено способів контролю знань.</p>
        </div>
    @else
        {{-- Список всех блоков контроля с полным содержимым --}}
        @foreach($controlBlocks as $controlBlock)
            <div class="control-section" id="block-{{ $controlBlock->id }}">
                <div class="control-section-header">
                    Засоби перевірки знань №{{ $controlBlock->order }}
                </div>
                <div class="control-section-content">
                    {{-- Полное содержимое блока контроля --}}
                    @if($controlBlock->elements->isNotEmpty())
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Питання для самоперевірки</h3>
                            @foreach($controlBlock->elements as $element)
                                @include('pages.subsections._block_element', ['element' => $element])
                            @endforeach
                        </div>
                    @endif
                    
                    {{-- Назначенный тест --}}
                    @if($controlBlock->test)
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-3">{{ $controlBlock->test->title }}</h3>
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-green-700">
                                    <p class="mb-2">Кількість питань: {{ $controlBlock->test->questions->count() }}</p>
                                    @if($controlBlock->test->description)
                                        <p class="text-gray-600">{{ $controlBlock->test->description }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('test.show', $controlBlock->test->id) }}" 
                                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors text-sm font-medium">
                                    Розпочати тест
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    {{-- Навигационные кнопки внизу страницы --}}
    <div class="mt-8 flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('subsections.show', $subsection) }}" class="nav-button nav-button-primary w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            До підрозділу
        </a>
        <a href="{{ route('sections.show', $subsection->section) }}" class="nav-button nav-button-secondary w-full sm:w-auto">
            До розділу
        </a>
    </div>
</div>

@if($targetBlockId)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetElement = document.getElementById('block-{{ $targetBlockId }}');
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
</script>
@endif

@endsection 