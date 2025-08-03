@extends('layouts.app')

@section('title', $subsection->title . ' - Практична робота №' . $practiceBlock->order . ' - Schoolbook')

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
    .level-badge {
        display: inline-block;
        padding: 0.25em 0.6em;
        font-size: .75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25rem;
        color: #fff;
    }
</style>
@endpush

@section('content')
{{-- Заголовок блока с фоном --}}
<div class="flex flex-col items-center justify-center border-b border-yellow-500">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 text-[#28569A]">Практичні завдання</h1>
            <h2 class="text-2xl font-semibold mb-2 text-gray-700">{{ $subsection->section->order }}.{{ $subsection->order }} {{ $subsection->title }}</h2>
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
            <li class="text-gray-700" aria-current="page">Практична робота №{{ $practiceBlock->order }} ({{ $subsection->section->order }}.{{ $subsection->order }})</li>
        </ol>
    </nav>

    <section class="block-content-bg rounded-lg shadow-lg mb-12 py-10 md:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-lg sm:text-xl mb-2 text-gray-200">{{ $subsection->title }}</h3>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3">
                Практична робота №{{ $practiceBlock->order }}
            </h1>
            @if($practiceBlock->level)
                <span class="level-badge"
                    style="background-color: 
                        @switch($practiceBlock->level)
                            @case('reproductive') #28a745; @break {{-- green --}}
                            @case('constructive') #ffc107; @break {{-- yellow --}}
                            @case('creative') #dc3545; @break {{-- red --}}
                            @default #6c757d; {{-- gray --}}
                        @endswitch
                    ">
                    Рівень: 
                    @switch($practiceBlock->level)
                        @case('reproductive') Репродуктивний @break
                        @case('constructive') Конструктивний @break
                        @case('creative') Творчий @break
                        @default {{ ucfirst($practiceBlock->level) }}
                    @endswitch
                </span>
            @endif
        </div>
    </section>

    <main class="content-card">
        @if($practiceBlock && $practiceBlock->elements->isNotEmpty())
            @foreach($practiceBlock->elements as $element)
                @include('pages.subsections._block_element', ['element' => $element])
            @endforeach
        @else
            <p class="text-gray-600">Практична робота ще не додана.</p>
        @endif
    </main>

    @php
        $allPracticeBlocks = $subsection->practiceBlocks()->orderBy('order')->get();
        $currentPracticeIndex = $allPracticeBlocks->search(function($pb) use ($practiceBlock) {
            return $pb->id === $practiceBlock->id;
        });
        $prevPractice = $currentPracticeIndex > 0 ? $allPracticeBlocks[$currentPracticeIndex - 1] : null;
        $nextPractice = $currentPracticeIndex < ($allPracticeBlocks->count() - 1) ? $allPracticeBlocks[$currentPracticeIndex + 1] : null;
    @endphp

    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('subsections.show', $subsection) }}" class="nav-button nav-button-secondary w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
            До підрозділу
        </a>
        
        <a href="{{ route('blocks.practice.all', $subsection) }}" class="nav-button nav-button-secondary w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" /></svg>
            Всі практичні роботи
        </a>
        
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
            @if($prevPractice)
                <a href="{{ route('blocks.practice.all', $subsection) }}?block_id={{ $prevPractice->id }}" class="nav-button nav-button-primary w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    Практ. №{{$prevPractice->order}} ({{ $subsection->section->order }}.{{ $subsection->order }})
                </a>
            @endif

            @if($nextPractice)
                <a href="{{ route('blocks.practice.all', $subsection) }}?block_id={{ $nextPractice->id }}" class="nav-button nav-button-primary w-full sm:w-auto">
                    Практ. №{{$nextPractice->order}} ({{ $subsection->section->order }}.{{ $subsection->order }})
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                </a>
            @else
                {{-- Если следующей практики нет, может быть ссылка на самост. работу или контроль --}}
                @if($subsection->homeworkBlock)
                    <a href="{{ route('blocks.homework.show', $subsection) }}" class="nav-button nav-button-primary w-full sm:w-auto">
                        Самостійна робота
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                @elseif($subsection->controlBlocks()->exists())
                     <a href="{{ route('blocks.control.show', [$subsection, $subsection->controlBlocks()->orderBy('order')->first()]) }}" class="nav-button nav-button-primary w-full sm:w-auto">
                        Засоби перевірки
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                @endif
            @endif
            <a href="{{ route('sections.index') }}" class="nav-button nav-button-secondary w-full sm:w-auto">Зміст</a>
        </div>
    </div>
</div>
@endsection 