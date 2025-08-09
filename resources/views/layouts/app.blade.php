<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Schoolbook')</title>

    {{-- Подключение Vite для Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- Дополнительные стили, если нужны --}}
    @stack('styles')
    
    {{-- Стили для автоматических ссылок на персоналии --}}
    <style>
        .figure-link {
            position: relative;
            text-decoration: underline;
            text-decoration-style: dotted;
            color: #2563eb !important;
        }

        .figure-link:hover {
            text-decoration-style: solid;
            color: #1d4ed8 !important;
        }

        .figure-link:hover::after {
            content: "Перейти до персоналії";
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
            margin-bottom: 5px;
        }

        /* Стили для автоматических ссылок на термины */
        .term-link {
            position: relative;
            text-decoration: underline;
            text-decoration-style: dotted;
            color: #059669 !important;
        }

        .term-link:hover {
            text-decoration-style: solid;
            color: #047857 !important;
        }

        .term-link:hover::after {
            content: "Перейти до терміну";
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
            margin-bottom: 5px;
        }

        /* Стили для обычных ссылок в контенте (не автоматических) */
        .tinymce-content a:not(.figure-link):not(.term-link) {
            color: #2563eb !important; /* Синий цвет для обычных ссылок */
            text-decoration: underline;
            text-decoration-color: #3b82f6;
            text-decoration-thickness: 2px;
            text-underline-offset: 2px;
            transition: all 0.2s ease-in-out;
        }

        .tinymce-content a:not(.figure-link):not(.term-link):hover {
            color: #1d4ed8 !important;
            text-decoration-color: #2563eb;
            background-color: #eff6ff;
            padding: 1px 2px;
            border-radius: 3px;
        }

        /* Стили для ссылок в кнопках и других элементах */
        .block-element a:not(.figure-link):not(.term-link) {
            color: #2563eb !important;
            text-decoration: underline;
            text-decoration-color: #3b82f6;
            text-decoration-thickness: 2px;
            text-underline-offset: 2px;
            transition: all 0.2s ease-in-out;
        }

        .block-element a:not(.figure-link):not(.term-link):hover {
            color: #1d4ed8 !important;
            text-decoration-color: #2563eb;
            background-color: #eff6ff;
            padding: 1px 2px;
            border-radius: 3px;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
    <style>
        body {
            font-family: "Roboto Slab", serif;
        }
        
        /* Стили для контента TinyMCE */
        .tinymce-content ol {
            list-style-type: decimal;
            margin-left: 20px;
            margin-bottom: 1rem;
        }
        
        .tinymce-content ul {
            list-style-type: disc;
            margin-left: 20px;
            margin-bottom: 1rem;
        }
        
        .tinymce-content li {
            margin-bottom: 0.5rem;
        }
        
        .tinymce-content p {
            margin-bottom: 1rem;
        }
        
        .tinymce-content h1, .tinymce-content h2, .tinymce-content h3, 
        .tinymce-content h4, .tinymce-content h5, .tinymce-content h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body class="font-sans antialiased bg-white text-gray-900 flex flex-col min-h-screen">
    <header class="bg-transparent z-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}">
                        <!-- <img src="{{ asset('images/schoolbook.png') }}" alt="Schoolbook Logo" class="h-10 sm:h-12 w-auto"> -->
                        <img src="{{ asset('storage/logo.png') }}" alt="Schoolbook Logo" class="h-10 sm:h-12 w-auto">
                        {{-- Если изображение schoolbook.png в public/storage/images/schoolbook.png, используйте:
                        <img src="{{ asset('storage/logo.png') }}" alt="Schoolbook Logo" class="h-10 sm:h-12 w-auto">
                        Пожалуйста, убедитесь, что изображение логотипа находится в правильной директории (например, public/images/)
                        и путь в asset() указан верно. Если его нет, сервер вернет 404 для логотипа.
                        Я предполагаю, что файл будет public/images/schoolbook.png
                        --}}
                    </a>
                </div>
                <nav class="hidden md:flex space-x-6 lg:space-x-8 ">
                    <a href="{{ route('sections.index') }}" class="text-gray-700 hover:text-[#3A6EA5] px-3 py-2 rounded-md text-sm font-medium">ЗМІСТ</a>
                    <!-- <a href="{{ route('dictionary.index') }}" class="text-gray-700 hover:text-[#3A6EA5] px-3 py-2 rounded-md text-sm font-medium">СЛОВНИК ДОВІДНИК</a> -->
                    <a href="{{ route('figures.index') }}" class="text-gray-700 hover:text-[#3A6EA5] px-3 py-2 rounded-md text-sm font-medium">ПЕРСОНАЛІЇ</a>
                    <a href="{{ route('terms.index') }}" class="text-gray-700 hover:text-[#3A6EA5] px-3 py-2 rounded-md text-sm font-medium">СЛОВНИК-ДОВІДНИК</a>
                    <a href="{{ route('mediacontent.index') }}" class="text-gray-700 hover:text-[#3A6EA5] px-3 py-2 rounded-md text-sm font-medium">МЕДІА КОНТЕНТ</a>
                    <a href="{{ route('literature') }}" class="text-gray-700 hover:text-[#3A6EA5] px-3 py-2 rounded-md text-sm font-medium">РЕКОМЕНДОВАНА ЛІТЕРАТУРА</a>
                </nav>
                {{-- Mobile menu button --}}
                <div class="md:hidden">
                    <button type="button" class="text-gray-700 hover:text-[#3A6EA5] focus:outline-none focus:text-[#3A6EA5]" aria-label="Toggle menu" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        {{-- Mobile menu, show/hide based on menu state. --}}
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('sections.index') }}" class="text-gray-700 hover:text-[#3A6EA5] block px-3 py-2 rounded-md text-base font-medium">ЗМІСТ</a>
                <a href="{{ route('dictionary.index') }}" class="text-gray-700 hover:text-[#3A6EA5] block px-3 py-2 rounded-md text-base font-medium">СЛОВНИК ДОВІДНИК</a>
                <a href="{{ route('figures.index') }}" class="text-gray-700 hover:text-[#3A6EA5] block px-3 py-2 rounded-md text-base font-medium">ПЕРСОНАЛІЇ</a>
                <a href="{{ route('terms.index') }}" class="text-gray-700 hover:text-[#3A6EA5] block px-3 py-2 rounded-md text-base font-medium">СЛОВНИК</a>
                <a href="{{ route('mediacontent.index') }}" class="text-gray-700 hover:text-[#3A6EA5] block px-3 py-2 rounded-md text-base font-medium">МЕДІА КОНТЕНТ</a>
                <a href="{{ route('literature') }}" class="text-gray-700 hover:text-[#3A6EA5] block px-3 py-2 rounded-md text-base font-medium">РЕКОМЕНДОВАНА ЛІТЕРАТУРА</a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-[#3A6EA5] text-white mt-auto">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h5 class="font-semibold text-lg mb-4">ЗМІСТ</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}#preface" class="hover:underline">Передмова</a></li> {{-- Предполагаем якорь на главной --}}
                        <li><a href="{{-- route('sections.show', ['section' => 1]) --}}" class="hover:underline">Розділ 1</a></li> {{-- Замените 1 на ID или slug первого раздела --}}
                        <li><a href="{{-- route('sections.show', ['section' => 2]) --}}" class="hover:underline">Розділ 2</a></li> {{-- Замените 2 на ID или slug второго раздела --}}
                        <li><a href="{{-- route('sections.show', ['section' => 3]) --}}" class="hover:underline">Розділ 3</a></li> {{-- Замените 3 на ID или slug третьего раздела --}}
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold text-lg mb-4">КОНТЕНТ</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('dictionary.index') }}" class="hover:underline">Словник-довідник</a></li>
                        <li><a href="{{ route('figures.index') }}" class="hover:underline">Персоналії</a></li>
                    <li><a href="{{ route('terms.index') }}" class="hover:underline">Словник</a></li>
                        <li><a href="#" class="hover:underline">Медіа-контент</a></li>
                        <li><a href="#" class="hover:underline">Бібліотека</a></li>
                        <li><a href="#" class="hover:underline">Художні тексти</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold text-lg mb-4">ПОСИЛАННЯ</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:underline">Про проєкт</a></li>
                        <li><a href="#" class="hover:underline">Для вчителів</a></li>
                        <li><a href="#" class="hover:underline">Для учнів</a></li>
                        <li><a href="#" class="hover:underline">Контакти</a></li>
                    </ul>
                </div>
                 <div>
                    <h5 class="font-semibold text-lg mb-4">РОЗДІЛИ</h5>
                    <ul class="space-y-2 text-sm">
                        {{-- Сюда можно динамически выводить первые несколько разделов, если они есть --}}
                        {{-- @php
                            $footerSections = \App\Models\Section::orderBy('id')->take(3)->get();
                        @endphp
                        @forelse ($footerSections as $section)
                            <li><a href="{{ route('sections.show', $section) }}" class="hover:underline">{{ $section->title }}</a></li>
                        @empty
                            <li><a href="{{ route('sections.index') }}" class="hover:underline">Всі розділи</a></li>
                        @endforelse --}}
                        {{-- Пока что статические, как в макете --}}
                        <li><a href="{{-- route('sections.show', ['section' => 1]) --}}" class="hover:underline">Розділ 1</a></li>
                        <li><a href="{{-- route('sections.show', ['section' => 2]) --}}" class="hover:underline">Розділ 2</a></li>
                        <li><a href="{{-- route('sections.show', ['section' => 3]) --}}" class="hover:underline">Розділ 3</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 pt-8 border-t border-blue-500 text-center text-sm">
                <p>&copy; {{ date('Y') }} SCHOOLBOOK. ВСІ ПРАВА ЗАХИЩЕНО.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    
    {{-- TinyMCE Editor - ЗАГРУЖАЕТСЯ В КОНЦЕ ДОКУМЕНТА --}}
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        console.log('TinyMCE загружен в конце документа:', typeof tinymce !== 'undefined');
    </script>
    
    <script>
        // Простой скрипт для мобильного меню, если не используется Alpine.js или подобное
        // document.addEventListener('DOMContentLoaded', function () {
        //     const menuButton = document.querySelector('[aria-label="Toggle menu"]');
        //     const mobileMenu = document.getElementById('mobile-menu');
        //     if (menuButton && mobileMenu) {
        //         menuButton.addEventListener('click', function () {
        //             mobileMenu.classList.toggle('hidden');
        //         });
        //     }
        // });
    </script>
</body>
</html> 