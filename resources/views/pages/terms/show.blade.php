@extends('layouts.app')

@section('title', $term->name . ' - Словник-довідник')

@section('content')
{{-- Шапка страницы в стиле других страниц --}}
<div class="flex flex-col items-center justify-center border-b border-yellow-500 mb-4">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">{{ $term->name }}</h1>
            <h2 class="text-base mb-4">Термін з словника-довідника</h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 pb-8">
    {{-- Хлебные крошки --}}
    <nav class="mb-10 text-sm text-gray-500 max-w-6xl mx-auto" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex space-x-2">
            <li><a href="{{ route('home') }}" class="text-[#3A6EA5] hover:underline">Головна</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('terms.index') }}" class="text-[#3A6EA5] hover:underline">Словник-довідник</a></li>
            <li><span>/</span></li>
            <li class="text-gray-700" aria-current="page">{{ $term->name }}</li>
        </ol>
    </nav>

    {{-- Основное содержимое --}}
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-6xl mx-auto">
        <div class="p-6">
            <div class="space-y-8">
                {{-- Толкования термина с изображениями --}}
                @foreach($term->definitions as $index => $definition)
                    <div class="definition-block p-6 {{ $index > 0 ? 'mt-6' : '' }}">
                        <div class="flex flex-col lg:flex-row gap-6">
                            {{-- Левая колонка с текстом --}}
                            <div class="{{ ($index === 0 && $term->image_path) || ($index > 0 && $definition->images->count() > 0) ? 'lg:w-2/3' : 'w-full' }}">
                                <div class="text-base leading-relaxed mb-4">
                                    {!! $definition->processed_definition !!}
                                </div>
                                
                                @if($definition->source)
                                    <div class="source-block bg-blue-50 p-4 rounded-lg border">
                                        <div class="text-sm font-medium text-gray-700 mb-2">Джерело:</div>
                                        <div class="text-sm text-gray-600 italic">{!! $definition->source !!}</div>
                                    </div>
                                @endif
                            </div>

                            {{-- Правая колонка с изображениями (только если есть изображения) --}}
                            @if(($index === 0 && $term->image_path) || ($index > 0 && $definition->images->count() > 0))
                                <div class="lg:w-1/3">
                                    @if($index === 0 && $term->image_path)
                                        {{-- Для первого толкования показываем основное изображение термина --}}
                                        <div class="image-item">
                                            <img src="{{ asset('storage/' . $term->image_path) }}" 
                                                 alt="{{ $term->name }}" 
                                                 class="w-full rounded-lg shadow-lg">
                                            <p class="text-sm text-gray-600 mt-2 text-center">{{ $term->name }}</p>
                                        </div>
                                    @elseif($index > 0 && $definition->images->count() > 0)
                                        {{-- Для остальных толкований показываем дополнительные изображения --}}
                                        <div class="space-y-4">
                                            @foreach($definition->images as $image)
                                                <div class="image-item">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                         alt="{{ $image->alt_text }}" 
                                                         class="w-full rounded-lg shadow-lg">
                                                    <p class="text-sm text-gray-600 mt-2 text-center">
                                                        {{ $image->alt_text }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
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