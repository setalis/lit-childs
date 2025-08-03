@extends('layouts.app')

@section('title', $figure->display_name . ' - Персоналії')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        {{-- Хлебные крошки --}}
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('figures.index') }}" class="hover:text-blue-600">Персоналії</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">{{ $figure->display_name }}</li>
            </ol>
        </nav>

        {{-- Основной контент --}}
        <div class="bg-white border border-yellow-400 rounded-2xl overflow-hidden shadow-lg">
            <div class="md:flex">
                {{-- Изображение --}}
                @if($figure->image_path)
                    <div class="md:w-1/3">
                        <div class="w-full h-96 md:h-full">
                            <img src="{{ asset('storage/' . $figure->image_path) }}" 
                                 alt="{{ $figure->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
                
                {{-- Текстовая информация --}}
                <div class="{{ $figure->image_path ? 'md:w-2/3' : 'w-full' }} p-8">
                    {{-- Заголовок --}}
                    <h1 class="text-3xl font-bold mb-6 text-gray-800 leading-tight">
                        {{ $figure->display_name }}
                    </h1>
                    
                    {{-- Биография --}}
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! process_figure_links(nl2br(e($figure->biography))) !!}
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Кнопка возврата --}}
        <div class="mt-8 text-center">
            <a href="{{ route('figures.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors duration-200 font-semibold text-sm uppercase tracking-wide">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Повернутися до списку персоналій
            </a>
        </div>
    </div>
</div>
@endsection 