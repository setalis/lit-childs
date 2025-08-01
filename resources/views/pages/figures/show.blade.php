@extends('layouts.app')

@section('title', $figure->display_name . ' - Персоналії')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="md:flex">
                @if($figure->image_path)
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $figure->image_path) }}" 
                             alt="{{ $figure->name }}" 
                             class="w-full h-auto object-cover md:h-full">
                    </div>
                @endif
                <div class="{{ $figure->image_path ? 'md:w-2/3' : 'w-full' }} p-8">
                                         <h1 class="text-3xl font-bold mb-6 text-gray-800">{{ $figure->display_name }}</h1>
                    
                    <div class="prose max-w-none">
                        {!! process_figure_links(nl2br(e($figure->biography))) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('figures.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Повернутися до списку персоналій
            </a>
        </div>
    </div>
</div>
@endsection 