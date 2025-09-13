@extends('layouts.app')

@section('title', 'Персоналії')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500 ">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Персоналії</h1>
            <h2 class="text-xl font-bold mb-4 uppercase">Видатні діячі культури, науки, мистецтва</h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>
<div class="container mx-auto px-4 py-8">
    <!-- <h1 class="text-3xl font-bold mb-6">Персоналії</h1> -->

    {{-- Панель фильтрации по буквам --}}
    @if($letters->isNotEmpty())
        <div class="mb-8 flex flex-wrap justify-center space-x-1">
            <a href="{{ route('figures.index') }}" 
               class="px-3 py-1 border rounded hover:bg-blue-500 hover:text-white {{ !$selectedLetter ? 'bg-blue-500 text-white' : 'bg-white text-blue-500' }}">
                Всі
            </a>
            @foreach($letters as $letter)
                <a href="{{ route('figures.index', ['letter' => $letter]) }}" 
                   class="px-3 py-1 border rounded hover:bg-blue-500 hover:text-white {{ $selectedLetter == $letter ? 'bg-blue-500 text-white' : 'bg-white text-blue-500' }}">
                    {{ $letter }}
                </a>
            @endforeach
        </div>
    @endif

    @if($figures->isEmpty() && $selectedLetter)
        <p class="text-center text-gray-600">Діячів на літеру "{{ $selectedLetter }}" не знайдено.</p>
    @elseif($figures->isEmpty())
        <p class="text-center text-gray-600">У розділі ще немає персоналій.</p>
    @else
        @foreach($figures as $letter => $figuresByLetter)
            @if(!$selectedLetter)
                <h2 class="text-2xl font-semibold mt-6 mb-3 text-gray-700">{{ $letter }}</h2>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($figuresByLetter as $figure)
                    <div class="bg-white border border-yellow-400 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                        {{-- Изображение --}}
                        @if($figure->image_path)
                            <div class="w-full h-72 overflow-hidden">
                                <img src="{{ asset('storage/' . $figure->image_path) }}" 
                                     alt="{{ $figure->display_name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                        
                        {{-- Контент карточки --}}
                        <div class="p-6">
                            {{-- Имя и годы жизни --}}
                            <h3 class="text-xl font-semibold mb-2 text-gray-800 leading-tight">
                                {{ $figure->display_name }}
                            </h3>
                            
                            {{-- Краткое описание --}}
                            <div class="text-gray-600 text-sm mb-4 leading-relaxed">
                                @if($figure->biography)
                                    {!! Str::limit(strip_tags($figure->biography, '<p><br><strong><em><u>'), 120) !!}
                                @else
                                    <span class="text-gray-400">Опис відсутній</span>
                                @endif
                            </div>
                            
                            {{-- Кнопка "Докладніше" --}}
                            <div class="flex justify-start">
                                <a href="{{ route('figures.show', $figure) }}" 
                                   class="inline-flex items-center px-6 py-3 bg-yellow-400 text-black font-semibold rounded-full hover:bg-yellow-500 transition-colors duration-200 text-sm uppercase tracking-wide">
                                    Докладніше
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>
@endsection 