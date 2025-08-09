@extends('layouts.app')

@section('title', $term->name . ' - Словник-довідник')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Хлебные крошки --}}
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-1">
            <li>
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Головна</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('terms.index') }}" class="text-blue-600 hover:text-blue-800">Словник-довідник</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <span class="text-gray-500">{{ $term->name }}</span>
            </li>
        </ol>
    </nav>

    {{-- Основное содержимое --}}
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold text-green-700 mb-6">{{ $term->name }}</h1>
            
            <div class="text-gray-700 leading-relaxed">
                @if($term->image_path)
                    {{-- Изображение с обтеканием текстом --}}
                    <img src="{{ asset('storage/' . $term->image_path) }}" 
                         alt="{{ $term->name }}" 
                         class="float-left mr-6 mb-4 max-w-xs w-full sm:max-w-sm md:max-w-md rounded-lg shadow-lg">
                @endif
                
                {{-- Толкования термина --}}
                <div class="space-y-6">
                    @foreach($term->definitions as $index => $definition)
                        <div class="definition-block border-l-4 border-green-500 pl-6 py-4 {{ $index > 0 ? 'mt-6' : '' }}">
                            <div class="text-base leading-relaxed mb-4">
                                {!! $definition->processed_definition !!}
                            </div>
                            
                            @if($definition->source)
                                <div class="source-block bg-gray-50 p-4 rounded-lg border">
                                    <div class="text-sm font-medium text-gray-700 mb-2">Джерело:</div>
                                    <div class="text-sm text-gray-600 italic">{{ $definition->source }}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Очистка float для предотвращения проблем с версткой --}}
            <div class="clear-both"></div>
        </div>
    </div>

    {{-- Кнопка возврата --}}
    <div class="mt-8 text-center">
        <a href="{{ route('terms.index', ['letter' => $term->first_letter]) }}" 
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Повернутися до словника
        </a>
    </div>
</div>
@endsection 