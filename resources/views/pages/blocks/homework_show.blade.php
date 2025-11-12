@extends('layouts.app')

@section('title', $subsection->title . ' - Самостійна робота - Schoolbook')

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
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .nav-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px; 
        text-transform: uppercase;
        font-weight: 600;
        transition: background-color 0.3s ease;
        text-align: center;
    }
    .nav-button-primary {
        background-color: #FEC200; 
        color: #212529;
    }
    .nav-button-primary:hover {
        background-color: #e0a800; 
    }
    .nav-button-secondary {
        background-color: #94BDDD; 
        color: white;
    }
    .nav-button-secondary:hover {
        background-color: #6a8eaa; 
    }
</style>
@endpush

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500 mb-8">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Самостійна робота {{ $subsection->section->order }}.{{ $subsection->order }}</h1>
            <h2 class="text-lg sm:text-lg font-bold mb-4 uppercase text-gray-600">{{ $subsection->title }}</h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Хлебные крошки --}}
    <nav class="mb-10 text-xs text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex space-x-2">
            <li><a href="{{ route('home') }}" class="text-[#3A6EA5] hover:underline">Головна</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('sections.index') }}" class="text-[#3A6EA5] hover:underline">Зміст</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('sections.show', $subsection->section) }}" class="text-[#3A6EA5] hover:underline">{{ $subsection->section->title }}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('subsections.show', $subsection) }}" class="text-[#3A6EA5] hover:underline">{{ $subsection->title }}</a></li>
            <li><span>/</span></li>
            <li class="text-gray-700" aria-current="page">Самостійна робота</li>
        </ol>
    </nav>

    <main class="border border-yellow-500 rounded-2xl p-8">
        @if($homeworkBlock && $homeworkBlock->elements->isNotEmpty())
            @foreach($homeworkBlock->elements as $element)
                @include('pages.subsections._block_element', ['element' => $element])
            @endforeach
        @else
            <p class="text-gray-600">Матеріали для самостійної роботи ще не додані.</p>
        @endif
    </main>

    <div class="mt-8 flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-14">
        <a href="{{ route('subsections.show', $subsection) }}" class="nav-button nav-button-secondary w-full sm:w-auto">             
            До підрозділу
        </a>
        @if($subsection->controlBlocks()->exists())
                <a href="{{ route('blocks.control.show', [$subsection, $subsection->controlBlocks()->orderBy('order')->first()]) }}" class="nav-button nav-button-primary w-full sm:w-auto">
                    Засоби перевірки
                </a>
            @endif
            <a href="{{ route('sections.index') }}" class="nav-button nav-button-secondary w-full sm:w-auto">Зміст</a>
        
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto mb-14">
            
        </div>
    </div>
</div>
@endsection 