@extends('layouts.app')
@section('title', 'Головна - Schoolbook')
@push('styles')
<style>
    .hero-bg {
        background-image: url("{{ asset('storage/hero-background.jpg') }}"); /* Замените на ваш путь к фону */
        background-size: cover;
        background-position: center center;
    }
    /* .section-card-image класс больше не используется, удаляем его 
    .section-card-image {
        width: 120px; 
        height: auto;
    } */
    .action-button {
        
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        text-align: center;
        transition: background-color 0.3s ease;
    }
    .action-button:hover {
        background-color: #e0a800; /* Более темный желтый при наведении */
    }

    .block-bg-dictionary {
        background-image: url("{{ asset('storage/dictionary-bg.jpg') }}"); /* Фон для блока словаря */
        background-size: 40%;
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
    {{-- Hero Section --}}
    <section class="hero-bg flex items-center h-full lg:py-38 py-24 -mt-16 border-b border-yellow-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left }}')]">
            <div class="md:w-2/3 lg:w-2/3">
                <h3 class="text-lg sm:text-lg mb-4 leading-tight font-bold text-[#94BDDD] uppercase">Інна Хижняк,  Ольга Хващевська, Ірина Лобачова</h3>
                <h1 class="text-3xl sm:text-4xl md:text-4xl font-bold leading-tight text-[#28569A] uppercase mb-8">Дитяча література з методикою навчання літературного читання</h1>
                <h4 class="text-2xl sm:text-2xl mb-8 text-[#8C8C8C] font-semibold">Електронний підручник</h4>
                <p class="text-lg sm:text-xl mb-12">для здобувачів бакалаврського рівня вищої освіти спеціальності 013 Початкова освіта</p> 
                <a href="{{ route('sections.index') }}" class="bg-[#FEC200] hover:bg-[#e0a800] rounded-full text-white px-8 py-4 uppercase font-bold">Розпочати навчання</a>
            </div>
        </div>
    </section>

    {{-- Sections Overview --}}
    <section class="mt-24 ">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-5xl font-bold text-center mb-12 text-[#3A6EA5]">РОЗДІЛИ ПІДРУЧНИКА</h2>
            @if($sections->isEmpty())
                <p class="text-center text-gray-600">На жаль, розділів ще немає.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8"> {{-- Изменено на 1 колонку для более точного соответствия макету карточки раздела --}}
                    @php
                        // Предполагаемые имена файлов изображений для разделов
                        $sectionImages = ['book-01.png', 'book-02.png', 'book-03.png'];
                    @endphp
                    @foreach($sections as $index => $section)
                        <div class="bg-white border border-yellow-300 rounded-3xl p-6 flex flex-col items-center justify-center space-x-6">  
                            <div class="flex flex-col flex-grow text-center items-center justify-center p-4">
                                <div class="flex items-center justify-center bg-yellow-300 rounded-full w-16 h-16 text-4xl font-bold text-black mb-8">{{$loop->iteration}}</div>
                                <h3 class="text-xl lg:text-base font-semibold mb-2 text-[#3A6EA5]">{{ $section->title }}</h3>
                                @if($section->description)
                                    <!-- <p class="text-gray-600 text-sm lg:text-base mb-4 flex-grow">{{ Str::limit($section->description, 150) }}</p> {{-- Описание, flex-grow для заполнения пространства --}} -->
                                @else
                                    <div class="flex-grow"></div> {{-- Заполнитель, если нет описания, чтобы кнопка была внизу --}}
                                @endif
                                <div class="flex items-center justify-center mb-3">
                                    <img src="{{ asset('storage/' . ($sectionImages[$index % count($sectionImages)] ?? 'book-default.png')) }}"
                                    alt="{{ $section->title }}"
                                    class="max-h-[200px] flex-shrink-0 rounded"> 
                                </div>
                                <a href="{{ route('sections.show', $section) }}" class=" text-white ">
                                    <div class="mt-auto px-8 py-4 rounded-full bg-[#94BDDD] hover:bg-[#6a8eaa]">
                                        ПЕРЕГЛЯНУТИ РОЗДІЛ
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Section dictionary --}}
    <section class="block-bg-dictionary py-16 border-y border-yellow-300">
        <div class="container max-w-7xl flex flex-col items-center md:flex-row gap-8 mx-auto px-4 sm:px-6 lg:px-8 bg-white border border-yellow-300 rounded-3xl ">
            <div class="w-1/2 p-6">
                <h2 class="text-5xl font-bold mb-6 text-[#3A6EA5]">Словник-довідник</h2>
                <p class="text-lg mb-12">Переглянути нові поняття та терміни у словнику</p>
                <a href="{{ route('dictionary.index') }}" class="bg-[#FEC200] hover:bg-[#e0a800] rounded-full text-white px-8 py-4 uppercase font-bold">Переглянути</a>
            </div>            
            <div class="w-1/2 p-6">
                <img src="{{ asset('storage/dictionary-img.jpg') }}" alt="Dictionary" class="w-full">
            </div>
        </div>
    </section>

    {{-- Section Personalities --}}
    <section class="block-bg-personalities py-4 border-b border-yellow-300">
        <div class="container flex flex-col md:flex-row items-center gap-8 mx-auto px-4 sm:px-6 lg:px-8">
            <div class="w-1/2 p-6">
                <img src="{{ asset('storage/personalities-img.jpg') }}" alt="Personalities" class="w-full">
            </div>
            <div class="w-1/2 p-6">
                <h2 class="text-5xl font-bold mb-6 text-[#3A6EA5]">Персоналії</h2>
                <p class="text-lg mb-12">Переглянути видатні постаті, письменників, науковців, критиків, чий внесок у дитячу літературу є значущим.</p>
                <a href="{{ route('figures.index') }}" class="bg-[#94BDDD] hover:bg-[#6a8eaa] rounded-full text-white px-8 py-4 uppercase font-bold">Переглянути</a>
            </div>
        </div>
    </section>

    {{-- Dictionary and Personalities Blocks --}}
    <section class="py-12 bg-cover bg-center block-bg-dictionary border-b border-yellow-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Dictionary Block --}}
                <div class="bg-white p-8 md:p-12 flex flex-col md:flex-row gap-2 justify-between items-center rounded-3xl border border-[#94BDDD]">
                    <div class="w-1/2">
                        <h3 class="text-3xl font-bold mb-6">Медіаконтент</h3>
                        <p class="mb-10 text-lg">Переглянути відео, прослухати аудіо</p>
                        <a href="{{ route('dictionary.index')}}" class="bg-[#FEC200] hover:bg-[#e0a800] rounded-full text-white px-8 py-4 uppercase font-bold">Переглянути</a>
                    </div>
                    <div class="w-1/2">
                        <img src="{{ asset('storage/media-img.jpg') }}" alt="Медіаконтент" class="w-full">
                    </div>                    
                </div>

                {{-- Personalities Block --}}
                <div class="bg-white p-8 md:p-12 flex flex-col md:flex-row justify-between items-start rounded-3xl border border-[#94BDDD]">
                    <div class="w-3/5">
                        <h3 class="text-3xl font-bold mb-3">Персоналії</h3>
                        <p class="mb-10 text-lg">Видатні письменники, науковці, критики, чий внесок у літературу є значущим.</p>
                        <a href="{{ route('figures.index') }}" class="bg-[#FEC200] hover:bg-[#e0a800] rounded-full text-white px-8 py-4 uppercase font-bold">ПЕРЕЙТИ ДО ПЕРСОНАЛІЙ</a>
                    </div>
                    <div class="w-2/5">
                        <img src="{{ asset('storage/biblio-img.jpg') }}" alt="Медіаконтент" class="w-full">
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    {{-- Test Tasks Block --}}
    <section class="py-6">
        <div class="container flex flex-col md:flex-row items-center justify-center mx-auto px-4 sm:px-6 lg:px-8">
            <div class="w-1/2">                
                <h2 class="text-3xl font-bold text-[#3A6EA5] mb-6">ТЕСТОВІ ЗАВДАННЯ</h2>
                <p class="text-gray-700 max-w-2xl mb-10 text-lg">Перевірте свої знання за допомогою інтерактивних тестів по кожному розділу та темі підручника.</p>
                <a href="#" class="bg-[#94BDDD] hover:bg-[#6a8eaa] rounded-full text-white px-8 py-4 uppercase font-bold">ПЕРЕЙТИ ДО ТЕСТІВ</a> {{-- Замените # на актуальный маршрут --}}
            </div>
            <div class="w-1/2">
                <img src="{{ asset('storage/test-tasks.jpg') }}" alt="Тестові завдання" class="mx-auto w-auto">
            </div>
        </div>
    </section>

@endsection 