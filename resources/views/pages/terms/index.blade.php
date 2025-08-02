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
                <img src="{{ asset('storage/biblio-img.jpg') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>
<div class="container mx-auto px-4 lg:px-8 py-8">   
    {{-- Панель фильтрации по буквам --}}
    @if($letters->isNotEmpty())
        <div class="mb-8 flex flex-wrap justify-center space-x-1">
            <a href="{{ route('terms.index') }}" 
               class="px-3 py-1 border rounded hover:bg-green-500 hover:text-white {{ !$selectedLetter ? 'bg-green-500 text-white' : 'bg-white text-green-500' }}">
                Всі
            </a>
            @foreach($letters as $letter)
                <a href="{{ route('terms.index', ['letter' => $letter]) }}" 
                   class="px-3 py-1 border rounded hover:bg-green-500 hover:text-white {{ $selectedLetter == $letter ? 'bg-green-500 text-white' : 'bg-white text-green-500' }}">
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
            @if(!$selectedLetter)
                <h2 class="text-2xl font-semibold mt-6 mb-3 text-gray-700">{{ $letter }}</h2>
            @endif
            
            @php
                $totalTerms = count($termsByLetter);
                $halfCount = ceil($totalTerms / 2);
                $column1 = $termsByLetter->take($halfCount);
                $column2 = $termsByLetter->skip($halfCount);
            @endphp
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-20 gap-y-6">
                {{-- Первая колонка --}}
                <div class="space-y-6">
                    @foreach($column1 as $term)
                        <a href="{{ route('terms.show', $term) }}">
                            <h3 class="text-xl font-semibold mb-2 text-green-700 underline decoration-dotted underline-offset-3">{{ $term->name }}</h3>
                        </a>
                    @endforeach
                </div>
                
                {{-- Вторая колонка --}}
                <div class="space-y-6">
                    @foreach($column2 as $term)
                        <a href="{{ route('terms.show', $term) }}">
                            <h3 class="text-xl font-semibold mb-2 text-green-700 underline decoration-dotted underline-offset-3">{{ $term->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection 