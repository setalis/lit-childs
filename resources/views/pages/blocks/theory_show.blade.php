@extends('layouts.app')

@section('title', $subsection->title . ' - Теоретичний матеріал - Schoolbook')

@push('styles')
<style>
    .block-content-bg {
        background-image: url("{{ asset('images/main-bg-1-1.png') }}"); 
        background-size: cover;
        background-position: center;
        color: white; 
    }
    .content-card {
        background-color: #ffffff;
        border-radius: 0.5rem; /* 8px */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 1.5rem; /* 24px */
        margin-bottom: 1.5rem; /* 24px */
    }
    .nav-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px; /* pill shape */
        text-transform: uppercase;
        font-weight: 600;
        transition: background-color 0.3s ease;
        text-align: center;
    }
    .nav-button-primary {
        background-color: #FEC200; /* yellow */
        color: #212529;
    }
    .nav-button-primary:hover {
        background-color: #e0a800; /* darker yellow */
    }
    .nav-button-secondary {
        background-color: #94BDDD; /* blue */
        color: white;
    }
    .nav-button-secondary:hover {
        background-color: #6a8eaa; /* darker blue */
    }
</style>
@endpush

@section('content')
{{-- Заголовок блока с фоном --}}
<div class="flex flex-col items-center justify-center border-b border-yellow-500">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Теоретичний матеріал</h1>
            <h2 class="text-3xl font-bold mb-4 uppercase">{{ $subsection->title }}</h2>
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
            <li><a href="{{ route('sections.show', $subsection->section) }}" class="text-[#3A6EA5] hover:underline">{{ $subsection->section->title }}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('subsections.show', $subsection) }}" class="text-[#3A6EA5] hover:underline">{{ $subsection->title }}</a></li>
            <li><span>/</span></li>
            <li class="text-gray-700" aria-current="page">Теоретичний матеріал</li>
        </ol>
    </nav>  
    

    {{-- Основной контент блока --}}
    <main class="">
        @if($theoryBlock && $theoryBlock->elements->isNotEmpty())
            @foreach($theoryBlock->elements as $element)
                @include('pages.subsections._block_element', ['element' => $element])
            @endforeach
        @else
            <p class="text-gray-600">Теоретичний матеріал для цього підрозділу ще не додано.</p>
        @endif
    </main>

    {{-- Навигационные кнопки --}}
    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('subsections.show', $subsection) }}" class="nav-button nav-button-secondary w-full sm:w-auto">
            <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5 inline-block mr-2\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z\" clip-rule=\"evenodd\" /></svg>
            Повернутися до підрозділу
        </a>
        
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
            @if($subsection->practiceBlocks()->exists())
            <a href="{{ route('blocks.practice.show', [$subsection, $subsection->practiceBlocks()->orderBy('order')->first()]) }}" class="nav-button nav-button-primary w-full sm:w-auto">
                Практична робота
                <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5 inline-block ml-2\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z\" clip-rule=\"evenodd\" /></svg>
            </a>
            @endif
            <a href="{{ route('sections.index') }}" class="nav-button nav-button-secondary w-full sm:w-auto">Зміст</a>
        </div>
    </div>
</div>
@endsection 