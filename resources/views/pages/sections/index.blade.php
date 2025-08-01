@extends('layouts.app') {{-- Или ваш основной макет --}}

@section('title', 'Зміст підручника - Schoolbook')

@push('styles')
<style>
    .hero-bg {
        background-image: url("{{ asset('images/hero-background.png') }}"); /* Замените на ваш путь к фону */
        background-size: cover;
        background-position: center;
    }
    /* .section-card-image класс больше не используется, удаляем его 
    .section-card-image {
        width: 120px; 
        height: auto;
    } */
    .action-button {
        background-color: #FFC107; /* Основной желтый цвет для кнопок */
        color: #212529; /* Темный цвет текста для контраста */
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem; /* rounded-md */
        text-transform: uppercase;
        display: inline-block;
        text-align: center;
        transition: background-color 0.3s ease;
    }
    .action-button:hover {
        background-color: #e0a800; /* Более темный желтый при наведении */
    }

    .block-bg-dictionary {
        background-image: url("{{ asset('images/dictionary-bg.png') }}"); /* Фон для блока словаря */
        background-size: cover;
        background-position: center;
        border-radius: 0.5rem; /* rounded-lg */
    }
    .block-bg-personalities {
        background-image: url("{{ asset('images/personalities-bg.png') }}"); /* Фон для блока персоналий */
        background-size: cover;
        background-position: center;
        border-radius: 0.5rem; /* rounded-lg */
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl md:text-4xl font-bold text-[#3A6EA5] mb-10 text-center">ЗМІСТ ПІДРУЧНИКА</h1>

    @if($sections->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p class="font-bold">Розділи не знайдено</p>
            <p>На жаль, на даний момент у підручнику немає доступних розділів. Будь ласка, спробуйте зайти пізніше.</p>
        </div>
    @else
        <div class="space-y-8">
            @foreach($sections as $section)
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold text-[#3A6EA5] mb-2">
                                <a href="{{ route('sections.show', $section) }}" class="hover:underline">
                                    {{ $section->title }}
                                </a>
                            </h2>
                            @if($section->description)
                                <p class="text-gray-600 text-sm mb-3 sm:mb-0 pr-4">{{ Str::limit($section->description, 250) }}</p>
                            @endif
                        </div>
                        <a href="{{ route('sections.show', $section) }}"
                           class="action-button mt-4 sm:mt-0 flex-shrink-0">
                           Переглянути розділ
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Dictionary and Personalities Blocks --}}
<section class="py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Dictionary Block --}}
            <div class="block-bg-dictionary p-8 md:p-12 text-white shadow-lg flex flex-col justify-between items-start">
                <div>
                    <h3 class="text-3xl font-bold mb-3">Словник довідник</h3>
                    <p class="mb-6 text-lg">Терміни, поняття та ключові слова з дитячої літератури та методики навчання.</p>
                </div>
                <a href="{{ route('dictionary.index') }}" class="action-button bg-white text-[#3A6EA5] hover:bg-gray-100 mt-auto">ПЕРЕЙТИ ДО СЛОВНИКА</a>
            </div>

            {{-- Personalities Block --}}
            <div class="block-bg-personalities p-8 md:p-12 text-white shadow-lg flex flex-col justify-between items-start">
                <div>
                    <h3 class="text-3xl font-bold mb-3">Персоналії</h3>
                    <p class="mb-6 text-lg">Видатні постаті, письменники, науковці, критики, чий внесок у дитячу літературу є значущим.</p>
                </div>
                <a href="{{ route('figures.index') }}" class="action-button bg-white text-[#3A6EA5] hover:bg-gray-100 mt-auto">ПЕРЕЙТИ ДО ПЕРСОНАЛІЙ</a>
            </div>
        </div>
    </div>
</section>

{{-- Test Tasks Block --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <img src="{{ asset('images/test-tasks-icon.png') }}" alt="Тестові завдання" class="mx-auto mb-6 h-20 w-auto">
         {{-- Убедитесь, что изображение 'test-tasks-icon.png' находится в public/images/ --}}
        <h2 class="text-3xl font-bold text-[#3A6EA5] mb-4">ТЕСТОВІ ЗАВДАННЯ</h2>
        <p class="text-gray-700 max-w-2xl mx-auto mb-8">Перевірте свої знання за допомогою інтерактивних тестів по кожному розділу та темі підручника.</p>
        <a href="#" class="action-button">ПЕРЕЙТИ ДО ТЕСТІВ</a> {{-- Замените # на актуальный маршрут --}}
    </div>
</section>

@endsection 