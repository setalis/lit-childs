@extends('layouts.app')

@section('title', $figure->display_name . ' - Персоналії')

@section('meta_description', 'Інформація про ' . $figure->display_name . ' - ' . $figure->biography)
@section('meta_keywords', 'Інформація про ' . $figure->display_name . ' - ' . $figure->biography)

@section('content')
<style>
    .prose ol {
        list-style-type: decimal;
        margin-bottom: 1rem;
        margin-left: 1rem;
    }
    .prose ul {
        list-style-type: disc;
        margin-bottom: 1rem;
        margin-left: 1rem;
    }
    .prose li {
        margin-bottom: 1rem;
    }
    .prose a {
        color: #28569A;
        text-decoration: underline;
    }
    .prose a:hover {
        color: #28569A;
    }
</style>
<div class="flex flex-col items-center justify-center border-b border-yellow-500 ">
    <div class="container max-w-7xl flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Персоналії</h1>
            <h2 class="text-3xl font-bold mb-4 uppercase">{{ $figure->display_name }}</h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>

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
            <div class="p-6 md:p-12">
                {{-- Заголовок имени --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    {{ $figure->display_name }}
                </h1>

                {{-- Контент с обтеканием изображения --}}
                                {{-- Контент с обтеканием изображения --}}
                <div class="relative overflow-hidden">
                    {{-- Изображение с float --}}
                    @if($figure->image_path)
                        <img class="float-left mr-8 mb-6 w-64 h-auto rounded-lg shadow-md" 
                             src="{{ asset('storage/' . $figure->image_path) }}" 
                             alt="{{ $figure->display_name }}" />
                    @else
                        <div class="float-left mr-8 mb-6 w-64 h-64 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center">
                            <svg class="w-16 h-16 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif

                    {{-- Основная биография --}}
                    <div class="prose  max-w-none text-gray-700 leading-relaxed mb-8">
                        {!! process_figure_links($figure->biography) !!}
                    </div>

                    {{-- Основные источники --}}
                    @if($figure->sources)
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 shadow-sm mb-8">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mr-4 shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-blue-800">Ключові джерела</h3>
                                    <!-- <p class="text-sm text-blue-600">Ключові джерела інформації</p> -->
                                </div>
                            </div>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! process_figure_links($figure->sources) !!}
                            </div>
                        </div>
                    @endif

                    {{-- Дополнительная биография --}}
                    @if($figure->biography_2)
                        <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
                            {!! process_figure_links($figure->biography_2) !!}
                        </div>
                    @endif

                    {{-- Дополнительные источники --}}
                    @if($figure->sources_2)
                        <div class="bg-gradient-to-r from-purple-50 to-violet-50 border border-purple-200 rounded-xl p-6 shadow-sm mb-8">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-violet-500 rounded-full flex items-center justify-center mr-4 shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-purple-800">Додаткові джерела</h3>
                                    <p class="text-sm text-purple-600">Додаткові матеріали та посилання</p>
                                </div>
                            </div>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! process_figure_links($figure->sources_2) !!}
                            </div>
                        </div>
                    @endif

                    {{-- Дополнительные блоки (для обратной совместимости) --}}
                    @if($figure->blocks->isNotEmpty())
                        @foreach($figure->blocks->sortBy('order') as $block)
                            @if($block->type === 'biography')
                                {{-- Блок биографии --}}
                                <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
                                    {!! process_figure_links($block->content) !!}
                                </div>
                            @elseif($block->type === 'sources')
                                {{-- Блок источников --}}
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 shadow-sm mb-8">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mr-4 shadow-md">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-semibold text-blue-800">Джерела</h3>
                                            <p class="text-sm text-blue-600">Ключові джерела інформації</p>
                                        </div>
                                    </div>
                                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                                        {!! process_figure_links($block->content) !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    {{-- Clearfix --}}
                    <div class="clear-both"></div>
                </div>

                {{-- Кнопка "Назад" --}}
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('figures.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold rounded-full hover:from-yellow-500 hover:to-yellow-600 transition-all duration-200 text-sm uppercase tracking-wide shadow-md hover:shadow-lg">
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