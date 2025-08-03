@extends('layouts.app')

@section('title', $section->title . ' - Schoolbook')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500 mb-8">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4 py-8">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Розділ {{ $section->order }}</h1>
            <h2 class="text-3xl sm:text-4xl font-bold mb-4 uppercase">{{ $section->title }}
            </h2>
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
            <li class="text-gray-700" aria-current="page">{{ $section->title }}</li>
        </ol>
    </nav>

    {{-- Заголовок раздела --}}
    <!-- <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg mb-8 py-8 px-6 text-white">
        <h1 class="text-3xl sm:text-4xl font-bold mb-4">{{ $section->title }}</h1>
        @if($section->description)
            <div class="text-blue-100 text-lg">
                {!! nl2br(e($section->description)) !!}
            </div>
        @endif
    </div> -->

    {{-- Список подразделов --}}
    @if($section->subsections->isNotEmpty())
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 4 mb-8">
            @foreach($section->subsections->sortBy('order') as $subsection)
                <div class="bg-white rounded-xl border-yellow-400 border-1 hover:shadow-lg transition-shadow duration-300">
                    <div class="p-8 flex flex-col justify-between w-full h-full">
                        <div class="mb-4 w-full">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2 w-full h-20">
                                <a href="{{ route('subsections.show', $subsection) }}" class="hover:text-blue-600 transition-colors block w-full">
                                    {{ $subsection->title }}
                                </a>
                            </h2>
                        </div>

                        {{-- Прогресс по подразделу --}}
                        <div class="space-y-3 flex-grow">
                            {{-- Теоретический блок --}}
                            <div class="flex items-center {{ $subsection->theoryBlock ? 'text-gray-600 hover:text-gray-800' : 'text-gray-400' }} ">
                                <svg class="w-6 h-6 mr-3 border border-yellow-300 rounded p-0.5" fill="#FFBB00" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('blocks.theory.show', $subsection) }}" class="text-gray-600 hover:text-gray-800 transition-colors duration-200 no-underline">
                                    <span class="font-medium">Теоретичний матеріал</span>
                                </a>
                            </div>

                            {{-- Практические задания --}}
                            @if($subsection->practiceBlocks->isNotEmpty())
                                <div class="">
                                    <div class="flex items-center text-gray-600 hover:text-gray-800 mb-4">
                                        <svg class="w-6 h-6 mr-3 border border-yellow-300 rounded p-0.5" fill="#FFBB00" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <a href="{{ route('blocks.practice.all', $subsection) }}" class="text-gray-600 hover:text-gray-800 transition-colors duration-200 no-underline">
                                            <span class="font-medium ">Практичні завдання</span>
                                        </a>
                                    </div>
                                    <ul class="ml-8 space-y-1 mb-4">
                                        @foreach($subsection->practiceBlocks->sortBy('order') as $practiceBlock)
                                            <li class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill w-5 h-5 border border-[#28569A] rounded p-0.5 mr-3 flex-shrink-0" viewBox="0 0 16 16">
                                                    <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                                </svg>
                                                <a href="{{ route('blocks.practice.all', $subsection) }}?block_id={{ $practiceBlock->id }}" class="text-gray-800 hover:text-yellow-600 transition-colors duration-200 no-underline">
                                                    @if($practiceBlock->level)
                                                        @switch($practiceBlock->level)
                                                            @case('reproductive') Репродуктивний рівень @break
                                                            @case('constructive') Конструктивний рівень @break
                                                            @case('creative') Творчий рівень @break
                                                            @default {{ ucfirst($practiceBlock->level) }} рівень
                                                        @endswitch
                                                    @else
                                                        Практична робота №{{ $practiceBlock->order }}
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <div class="flex items-center opacity-50">
                                   <svg class="w-6 h-6 border-yellow-300 text-gray-400 rounded p-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span class="text-gray-500">Практичні завдання</span>
                                </div>
                            @endif

                            {{-- Завдання для самостійної роботи --}}
                            <div class="flex items-center {{ !$subsection->homeworkBlock ? 'opacity-50' : '' }}">
                                <svg class="w-6 h-6 {{ $subsection->homeworkBlock ? 'text-yellow-500' : 'text-gray-400' }} border border-yellow-300 rounded p-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                @if($subsection->homeworkBlock)
                                    <a href="{{ route('blocks.homework.show', $subsection) }}" class="text-gray-800 hover:text-yellow-600 transition-colors duration-200 no-underline">Завдання для самостійної роботи</a>
                                @else
                                    <span class="text-gray-500">Завдання для самостійної роботи</span>
                                @endif
                            </div>

                            {{-- Засоби контролю --}}
                            @php
                                $questionsBlocks = $subsection->controlBlocks->where('type', 'questions')->sortBy('order');
                                $testBlocks = $subsection->controlBlocks->where('type', 'test')->sortBy('order');
                                $hasControlBlocks = $questionsBlocks->isNotEmpty() || $testBlocks->isNotEmpty();
                            @endphp
                            
                            @if($hasControlBlocks)
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-yellow-500 border border-yellow-300 rounded p-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span class="font-medium text-gray-800">Засоби контролю</span>
                                </div>
                                <ul class="pl-8 space-y-2">
                                    @if($questionsBlocks->isNotEmpty())
                                        <li class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill w-5 h-5 border border-[#28569A] rounded p-0.5 mr-3 flex-shrink-0" viewBox="0 0 16 16">
                                                <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                            </svg>
                                            <a href="{{ route('blocks.control.show', [$subsection, $questionsBlocks->first()]) }}" class="text-gray-800 hover:text-yellow-600 transition-colors duration-200 no-underline">
                                                Питання та завдання для самоперевірки
                                            </a>
                                        </li>
                                    @endif
                                    
                                    @if($testBlocks->isNotEmpty())
                                        <li class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28569A" class="bi bi-pin-angle-fill w-5 h-5 border border-[#28569A] rounded p-0.5 mr-3 flex-shrink-0" viewBox="0 0 16 16">
                                                <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146"/>
                                            </svg>
                                            <a href="{{ route('blocks.control.show', [$subsection, $testBlocks->first()]) }}" class="text-gray-800 hover:text-yellow-600 transition-colors duration-200 no-underline">
                                                Тестові завдання
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @else
                                <div class="flex items-center opacity-50">
                                    <svg class="w-6 h-6 text-gray-400 border border-gray-300 rounded p-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span class="text-gray-500">Засоби контролю</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200 flex items-center justify-between">
                            <a href="{{ route('subsections.show', $subsection) }}" class="inline-flex items-center text-[#28569A] hover:text-blue-800 font-medium">
                                Відкрити підрозділ
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <span class="text-sm bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $subsection->order }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500 text-lg">У цьому розділі поки немає підрозділів.</p>
        </div>
    @endif

    @if($section->description)
        <div class=" text-lg">
            {!! nl2br(e($section->description)) !!}
        </div>
    @endif

    {{-- Навигация --}}
    <div class="mt-8 flex justify-center">
        <a href="{{ route('sections.index') }}" class="inline-flex items-center px-5 py-3 bg-yellow-500 text-white rounded-full hover:bg-[#94BDDD] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            До змісту підручника
        </a>
    </div>
</div>
@endsection 