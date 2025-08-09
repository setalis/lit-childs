@extends('layouts.app')

@section('title', 'Словник-довідник')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500 mb-8">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Словник-довідник</h1>
            <h2 class="text-base mb-4">Перглянути нові поняття та терміни
            </h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>
<div class="container mx-auto px-4 py-8">

    {{-- Панель фильтрации по буквам --}}
    @if($letters->isNotEmpty())
        <div class="mb-8 flex flex-wrap justify-center space-x-1">
            <a href="{{ route('dictionary.index') }}" 
               class="px-3 py-1 border rounded hover:bg-[#94BDDD] hover:text-white {{ !$selectedLetter ? 'bg-[#94BDDD] text-white' : 'bg-white text-blue-500' }}">
                Всі
            </a>
            @foreach($letters as $letter)
                <a href="{{ route('dictionary.index', ['letter' => $letter]) }}" 
                   class="px-3 py-1 border rounded hover:bg-[#94BDDD] hover:text-white {{ $selectedLetter == $letter ? 'bg-[#FEC200] text-white' : 'bg-white text-blue-500' }}">
                    {{ $letter }}
                </a>
            @endforeach
        </div>
    @endif

    @if($terms->isEmpty() && $selectedLetter)
        <p class="text-center text-gray-600">Термінів на літеру "{{ $selectedLetter }}" не знайдено.</p>
    @elseif($terms->isEmpty())
        <p class="text-center text-gray-600">У словнику ще немає термінів.</p>
    @else
        @foreach($terms as $letter => $termsByLetter)
            @if(!$selectedLetter) {{-- Показываем букву только если не выбран конкретный фильтр --}}
                <h2 class="text-2xl font-semibold mt-6 mb-3 text-gray-700">{{ $letter }}</h2>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($termsByLetter as $term)
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-2 text-blue-700">{{ $term->name }}</h3>
                        @if($term->image_path)
                            <img src="{{ asset('storage/' . $term->image_path) }}" alt="{{ $term->name }}" class="w-full h-auto object-cover rounded mb-3 max-h-48">
                        @endif
                        
                        {{-- Показываем первое толкование для краткого просмотра --}}
                        @if($term->definitions->isNotEmpty())
                            <div class="text-gray-600 text-sm mb-3">
                                {{ Str::limit($term->definitions->first()->definition, 150) }}
                            </div>
                            
                            @if($term->definitions->count() > 1)
                                <div class="text-xs text-blue-600 font-medium">
                                    + ще {{ $term->definitions->count() - 1 }} {{ $term->definitions->count() == 2 ? 'толкування' : 'толкувань' }}
                                </div>
                            @endif
                        @else
                            <p class="text-gray-400 text-sm">Толкування відсутнє</p>
                        @endif
                        
                        <div class="mt-4">
                            <a href="{{ route('terms.show', $term) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Докладніше →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>
@endsection 