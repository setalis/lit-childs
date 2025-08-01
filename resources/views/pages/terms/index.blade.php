@extends('layouts.app')

@section('title', 'Словник-довідник')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Словник-довідник</h1>

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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($termsByLetter as $term)
                    <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow">
                        <h3 class="text-xl font-semibold mb-2 text-green-700">{{ $term->name }}</h3>
                        @if($term->image_path)
                            <img src="{{ asset('storage/' . $term->image_path) }}" alt="{{ $term->name }}" class="w-full h-auto object-cover rounded mb-3 max-h-40">
                        @endif
                        <p class="text-gray-600 text-sm mb-3">{!! process_figure_links(Str::limit($term->definition, 150)) !!}</p>
                        <a href="{{ route('terms.show', $term) }}" 
                           class="inline-flex items-center text-green-600 hover:text-green-800 text-sm font-medium">
                            Детальніше
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>
@endsection 