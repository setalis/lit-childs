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
            {{-- Контент с изображением слева и текстом справа --}}
            <div class="p-6 md:p-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    {{-- Изображение слева --}}
                    <div class="lg:w-1/3">
                        @if($figure->image_path)
                            <div class="sticky top-4">
                                <img src="{{ asset('storage/' . $figure->image_path) }}" 
                                     alt="{{ $figure->display_name }}" 
                                     class="w-full h-auto rounded-lg shadow-md">
                            </div>
                        @else
                            <div class="w-full h-64 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Текст справа --}}
                    <div class="lg:w-2/3">
                        {{-- Заголовок имени --}}
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            {{ $figure->display_name }}
                        </h1>

                        {{-- Основная биография (без оформления и заголовка) --}}
                        <div class="mb-8">
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! process_figure_links($figure->biography) !!}
                            </div>
                        </div>

                        {{-- Дополнительная биография --}}
                        @if($figure->biography_2)
                            <div class="mb-8">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-green-800">Додаткова інформація</h3>
                                    </div>
                                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                                        {!! process_figure_links($figure->biography_2) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Основные источники --}}
                        @if($figure->sources)
                            <div class="mb-8">
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Джерела</h2>
                                <div class="prose max-w-none text-gray-700 leading-relaxed">
                                    {!! process_figure_links($figure->sources) !!}
                                </div>
                            </div>
                        @endif

                        {{-- Дополнительные источники --}}
                        @if($figure->sources_2)
                            <div class="mb-8">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-blue-800">Додаткові джерела</h3>
                                    </div>
                                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                                        {!! process_figure_links($figure->sources_2) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Дополнительные блоки (для обратной совместимости) --}}
                        @if($figure->blocks->isNotEmpty())
                            @foreach($figure->blocks->sortBy('order') as $block)
                                <div class="mb-8">
                                    @if($block->type === 'biography')
                                        {{-- Блок биографии --}}
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                            <div class="flex items-center mb-4">
                                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-xl font-semibold text-green-800">Додаткова інформація</h3>
                                            </div>
                                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                                {!! process_figure_links($block->content) !!}
                                            </div>
                                        </div>
                                    @elseif($block->type === 'sources')
                                        {{-- Блок источников --}}
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                            <div class="flex items-center mb-4">
                                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-xl font-semibold text-blue-800">Джерела</h3>
                                            </div>
                                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                                {!! process_figure_links($block->content) !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Кнопка "Назад" --}}
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('figures.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-yellow-400 text-black font-semibold rounded-full hover:bg-yellow-500 transition-colors duration-200 text-sm uppercase tracking-wide">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Назад до списку
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 