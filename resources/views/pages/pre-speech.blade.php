@extends('layouts.app')

@section('title', ' - Schoolbook')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Передмова</h1>
            <h2 class="text-xl font-bold mb-4">Сучасні підходи до вивчення дитячої літератури й методики навчання літературного читання у цифровому підручнику</h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    {{-- Хлебные крошки --}}
    <nav class="text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex space-x-2">
            <li><a href="{{ route('home') }}" class="text-[#3A6EA5] hover:underline">Головна</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('sections.index') }}" class="text-[#3A6EA5] hover:underline">Зміст</a></li>
            <li><span>/</span></li>
            <li class="text-gray-700" aria-current="page">Література</li>
        </ol>
    </nav>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-8 pt-4">
    <div class="bg-white rounded-lg shadow-lg p-8">
        
    </div>
</div>
@endsection

<style>
.nav-card-button {
    @apply bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 text-center block;
}

.button-theory:hover {
    @apply bg-blue-50;
}

.button-practice:hover {
    @apply bg-orange-50;
}

.button-homework:hover {
    @apply bg-purple-50;
}

.button-control:hover {
    @apply bg-red-50;
}

.nav-button {
    @apply inline-flex items-center px-4 py-2 rounded-lg font-medium transition-colors;
}

.nav-button-secondary {
    @apply bg-gray-600 text-white hover:bg-gray-700;
}
</style>