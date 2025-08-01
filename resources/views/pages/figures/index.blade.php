@extends('layouts.app')

@section('title', 'Персоналії')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Персоналії</h1>

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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($figuresByLetter as $figure)
                    <div class="bg-white shadow-lg rounded-lg p-6">
                                                 <h3 class="text-xl font-semibold mb-2 text-blue-700">{{ $figure->display_name }}</h3>
                        @if($figure->image_path)
                            <img src="{{ asset('storage/' . $figure->image_path) }}" alt="{{ $figure->name }}" class="w-full h-auto object-cover rounded mb-3 max-h-60">
                        @endif
                        <p class="text-gray-600 text-sm mb-3">{!! process_figure_links(Str::limit($figure->biography, 200)) !!}</p>
                        <a href="{{ route('figures.show', $figure) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
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