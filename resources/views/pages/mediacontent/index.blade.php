@extends('layouts.app')

@section('title', ' - Schoolbook')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Медиа-контент</h1>
            <h2 class="text-xl font-bold mb-4 ">Навчальні матеріали та ресурси</h2>
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
            <li class="text-gray-700" aria-current="page">Медиа-контент</li>
        </ol>
    </nav>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-8 pt-4">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-[#28569A] mb-6">Навчальні матеріали та ресурси</h2>
        
        <!-- Підручники та вебінари -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                1. Підручники та вебінари з української мови та читання
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Підручник з української мови та читання для 2 класу. Авторський вебінар М. Вашуленко, О. Вашуленко.</p>
                        <a href="https://www.youtube.com/watch?v=GJqISF6ss2M&t=4s" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.2</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Навчальний посібник "Українська мова та читання" для 2 кл. М. Вашуленка, О. Вашуленко, С. Дубовик.</p>
                        <a href="https://www.youtube.com/watch?v=vwjM1vUFxvM" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.3</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Майстер-клас "Застосування посібника "Українська мова. Читання 2 кл." М. Вашуленка, О.Вашуленко.</p>
                        <a href="https://www.youtube.com/watch?v=iJC-LuP01hM" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути майстер-клас →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.4</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Українська мова та читання 3 клас. Вебінар Миколи Вашуленка, Оксани Вашуленко.</p>
                        <a href="https://www.youtube.com/watch?v=p_V6ndXU9Ok&t=23s" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.5</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Підручник "Українська мова" 4 кл. Вашуленка М. С., Васильківської Н. А.</p>
                        <a href="https://www.youtube.com/watch?v=UcqPHliGsoY" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.6</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Вашуленко О.В. Підручник "Літературне читання" 4 кл.</p>
                        <a href="https://www.youtube.com/watch?v=ymI5yJkCopo&t=16s" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.7</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">"Українська мова та читання". 2 клас. Авт. Остапенко Г. С.</p>
                        <a href="https://www.youtube.com/watch?v=8t1Mti496aY" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.8</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Підручник "Українська мова та читання", 2 клас: особливості роботи. Вебінар Ганни Остапенко.</p>
                        <a href="https://www.youtube.com/watch?v=EQfNQqjL910" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.9</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Українська мова і читання 3 клас. Вебінар.</p>
                        <a href="https://www.youtube.com/watch?v=KrGZYcod1f4" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.10</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">"Українська мова та читання", 3 клас, тиждень 29. Авт. Остапенко Г. С.</p>
                        <a href="https://www.youtube.com/watch?v=nDr9w-6L1X0" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">1.11</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Підручник "Українська мова та читання", 4 клас: особливості роботи. Вебінар Ганни Остапенко.</p>
                        <a href="https://www.youtube.com/watch?v=_CFMK3W1whY" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Артикуляційна гімнастика -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-green-200 pb-2">
                2. Артикуляційна гімнастика та логопедичні матеріали
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="text-sm font-medium text-green-600 bg-white px-2 py-1 rounded-full">2.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Артикуляційна гімнастика для дітей. Соробан. Школа усного рахунку. 2018.</p>
                        <a href="https://soroban.ua/ua/blog/artikulyacionnaya-gimnastika-dlya-detej/" target="_blank" class="text-green-600 hover:text-green-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="text-sm font-medium text-green-600 bg-white px-2 py-1 rounded-full">2.2</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Артикуляційна гімнастика для постановки шиплячих звуків. 2023.</p>
                        <a href="https://www.youtube.com/watch?v=XX45w7Ams5c" target="_blank" class="text-green-600 hover:text-green-800 underline text-sm">Переглянути відео →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="text-sm font-medium text-green-600 bg-white px-2 py-1 rounded-full">2.3</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Артикуляційна гімнастика. Всеосвіта. 2018.</p>
                        <a href="https://vseosvita.ua/library/artikulacijna-gimnastika-7527.html" target="_blank" class="text-green-600 hover:text-green-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="text-sm font-medium text-green-600 bg-white px-2 py-1 rounded-full">2.4</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Артикуляційна гімнастика. LogoClub. 2024.</p>
                        <a href="https://www.logoclub.com.ua/zvukovimova/artikulyatsijna-gimnastika" target="_blank" class="text-green-600 hover:text-green-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="text-sm font-medium text-green-600 bg-white px-2 py-1 rounded-full">2.5</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Артикуляційна гімнастика. Логопедичний центр «Інтелект». 2018.</p>
                        <a href="https://www.youtube.com/watch?v=iD8bkiAJ054" target="_blank" class="text-green-600 hover:text-green-800 underline text-sm">Переглянути відео →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="text-sm font-medium text-green-600 bg-white px-2 py-1 rounded-full">2.6</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Балаклійський інклюзивно-ресурсний центр. 2019.</p>
                        <a href="http://balakliya-irc.edu.kh.ua/Files/downloads/%D0%B0%D1%80%D1%82%D0%B8%D0%BA%D1%83%D0%BB%D1%8F%D1%86%D1%96%D0%B9%D0%BD%D0%B0%20%D0%B3%D1%96%D0%BC%D0%BD%D0%B0%D1%81%D1%82%D0%B8%D0%BA%D0%B0.pdf" target="_blank" class="text-green-600 hover:text-green-800 underline text-sm">Завантажити PDF →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Аудиоказки -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                3. Аудиоказки
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="text-sm font-medium text-purple-600 bg-white px-2 py-1 rounded-full">3.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Аудіоказка для дітей «Вередлива принцеса». Послухай казку. 2017.</p>
                        <a href="https://www.youtube.com/watch?v=dZWrdz3LPN4" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Послухати казку →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="text-sm font-medium text-purple-600 bg-white px-2 py-1 rounded-full">3.2</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Аудіоказки українською мовою. Рукавичка. 2017.</p>
                        <a href="https://www.youtube.com/watch?v=H1PnrR1dzgE" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Послухати казку →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="text-sm font-medium text-purple-600 bg-white px-2 py-1 rounded-full">3.3</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Забавлянки та співанки з Росавою – вальсувало совеня. 2014.</p>
                        <a href="https://www.youtube.com/watch?v=Z2sjaV6nplU" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Переглянути відео →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="text-sm font-medium text-purple-600 bg-white px-2 py-1 rounded-full">3.4</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Збірка казок українською для малечі. Файна Мьюзік. 2020.</p>
                        <a href="https://www.youtube.com/watch?v=E8GTFG7Baxk" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Переглянути збірку →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="text-sm font-medium text-purple-600 bg-white px-2 py-1 rounded-full">3.5</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Летючий корабель (Українська народна казка). Аудіоказка. 2023.</p>
                        <a href="https://www.youtube.com/watch?v=FDzdAcTb7DM" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Послухати казку →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="text-sm font-medium text-purple-600 bg-white px-2 py-1 rounded-full">3.6</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Мала сторінка. Збірка забавлянок для дітей. 2024.</p>
                        <a href="https://mala.storinka.org/%D0%B7%D0%B1%D1%96%D1%80%D0%BA%D0%B0-%D0%B7%D0%B0%D0%B1%D0%B0%D0%B2%D0%BB%D1%8F%D0%BD%D0%BE%D0%BA-%D0%B4%D0%BB%D1%8F-%D0%B4%D1%96%D1%82%D0%B5%D0%B9.html" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Переглянути збірку →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="text-sm font-medium text-purple-600 bg-white px-2 py-1 rounded-full">3.7</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Все для дітей. Дитячі забавлянки. 2014.</p>
                        <a href="http://allforchildren.com.ua/poteshki01.htm" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Переглянути матеріали →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Балаклійський інклюзивно-ресурсний центр -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                4. Балаклійський інклюзивно-ресурсний центр
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                    <span class="text-sm font-medium text-red-600 bg-white px-2 py-1 rounded-full">4.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Балаклійський інклюзивно-ресурсний центр. 2019.</p>
                        <a href="http://balakliya-irc.edu.kh.ua/Files/downloads/%D0%B0%D1%80%D1%82%D0%B8%D0%BA%D1%83%D0%BB%D1%8F%D1%86%D1%96%D0%B9%D0%BD%D0%B0%20%D0%B3%D1%96%D0%BC%D0%BD%D0%B0%D1%81%D1%82%D0%B8%D0%BA%D0%B0.pdf" target="_blank" class="text-red-600 hover:text-red-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Блог вчителя О. Мацюк -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                5. Блог вчителя О. Мацюк
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">5.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Блог вчителя О. Мацюк Порушення читання та письма. URL: http://oksanalogoped.blogspot.com/2017/01/blog-post.html</p>
                        <a href="http://oksanalogoped.blogspot.com/2017/01/blog-post.html" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Богатко С. З досвіду роботи -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                6. Богатко С. З досвіду роботи
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <span class="text-sm font-medium text-yellow-600 bg-white px-2 py-1 rounded-full">6.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Богатко С. З досвіду роботи «Розвиток читацької компетентності молодших школярів». URL: https://naurok.com.ua/z-dosvidu-roboti-rozvitok-chitacko-kompetentnosti-molodshih-shkoliariv-18128.html</p>
                        <a href="https://naurok.com.ua/z-dosvidu-roboti-rozvitok-chitacko-kompetentnosti-molodshih-shkoliariv-18128.html" target="_blank" class="text-yellow-600 hover:text-yellow-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Бойко І. М. Дидактичні ігри на уроці читання -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                7. Бойко І. М. Дидактичні ігри на уроці читання
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors">
                    <span class="text-sm font-medium text-pink-600 bg-white px-2 py-1 rounded-full">7.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Бойко І. М. Дидактичні ігри на уроці читання. Освітній портал «Super-urok.ua». 2024. URL: https://super.urok-ua.com/didaktichni-igri-na-urotsi-chitannya/</p>
                        <a href="https://super.urok-ua.com/didaktichni-igri-na-urotsi-chitannya/" target="_blank" class="text-pink-600 hover:text-pink-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Бондаренко О. Формування читацької компетентності молодших школярів -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                8. Бондаренко О. Формування читацької компетентності молодших школярів
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <span class="text-sm font-medium text-indigo-600 bg-white px-2 py-1 rounded-full">8.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Бондаренко О. Формування читацької компетентності молодших школярів. URL: http://ukped.com/statti/teorija-navchannja/5080-formuvannia-chytatskoi-kompetentnosti-molodshykh-shkoliariv.html</p>
                        <a href="http://ukped.com/statti/teorija-navchannja/5080-formuvannia-chytatskoi-kompetentnosti-molodshykh-shkoliariv.html" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Вебінари та конференції -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-indigo-200 pb-2">
                5. Вебінари та конференції
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <span class="text-sm font-medium text-indigo-600 bg-white px-2 py-1 rounded-full">5.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Вебінар «Реалізація компетентнісного підходу на уроках української мови та літературного читання в початковій школі».</p>
                        <a href="https://www.youtube.com/watch?v=r9BuF1PF2Fw" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <span class="text-sm font-medium text-indigo-600 bg-white px-2 py-1 rounded-full">5.2</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Вебінар «Сучасний урок літературного читання» (Інноваційні технології).</p>
                        <a href="https://www.youtube.com/watch?v=8O7OJVlh7mA" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <span class="text-sm font-medium text-indigo-600 bg-white px-2 py-1 rounded-full">5.3</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Виступ Миколи Вашуленка на Всеукраїнській конференції Інституту педагогіки НАПН та ВД "Освіта".</p>
                        <a href="https://www.youtube.com/watch?v=jN0piR9jGYQ" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline text-sm">Переглянути виступ →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <span class="text-sm font-medium text-indigo-600 bg-white px-2 py-1 rounded-full">5.4</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Оксана Онопрієнко про вибір типової освітньої програми для вчителів.</p>
                        <a href="https://www.youtube.com/watch?v=BvCUb2qc_gs&list=PL7w9d-B_UG-vSaNuW15BDtipABPzgEOQv" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline text-sm">Переглянути вебінар →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Методична розробка «Використання інтерактивних методів навчання на уроках літературного читання та української мови в початкових класах» -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                31. Методична розробка «Використання інтерактивних методів навчання на уроках літературного читання та української мови в початкових класах»
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">31.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Методична розробка «Використання інтерактивних методів навчання на уроках літературного читання та української мови в початкових класах» : із досвіду роботи вчителя початкових класів О. П. Шумакової. URL: https://ru.osvita.ua/school/lessons_summary/edu_technology/50544/</p>
                        <a href="https://ru.osvita.ua/school/lessons_summary/edu_technology/50544/" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Новий стандарт початкової освіти – без форм, парт та уроків  (2018) -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                32. Новий стандарт початкової освіти – без форм, парт та уроків  (2018)
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">32.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Новий стандарт початкової освіти – без форм, парт та уроків  (2018). 12 Канал. URL: https://www.youtube.com/watch?v=UyeSt54OURQ</p>
                        <a href="https://www.youtube.com/watch?v=UyeSt54OURQ" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Нові стандарти початкової освіти. Українські реформи (2018) -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                33. Нові стандарти початкової освіти. Українські реформи (2018)
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">33.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Нові стандарти початкової освіти. Українські реформи (2018). UATV Channel. URL: https://www.youtube.com/watch?v=FJRaAPRU_7E</p>
                        <a href="https://www.youtube.com/watch?v=FJRaAPRU_7E" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Оксана Онопрієнко про вибір типової освітньої програми для вчителів -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                34. Оксана Онопрієнко про вибір типової освітньої програми для вчителів
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">34.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Оксана Онопрієнко про вибір типової освітньої програми для вчителів. URL: https://www.youtube.com/watch?v=BvCUb2qc_gs&list=PL7w9d-B_UG-vSaNuW15BDtipABPzgEOQv</p>
                        <a href="https://www.youtube.com/watch?v=BvCUb2qc_gs&list=PL7w9d-B_UG-vSaNuW15BDtipABPzgEOQv" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Оновлені програми для початкової школи, поради вчителям, додаткові навчальні матеріали -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                35. Оновлені програми для початкової школи, поради вчителям, додаткові навчальні матеріали
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">35.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Оновлені програми для початкової школи, поради вчителям, додаткові навчальні матеріали. URL: https://www.ed-era.com/mon.html</p>
                        <a href="https://www.ed-era.com/mon.html" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Основні принципи Державного стандарту початкової освіти -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                36. Основні принципи Державного стандарту початкової освіти
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">36.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Основні принципи Державного стандарту початкової освіти. Онлайн-курс для вчителів початкової школи. EdEra. 2018. URL: https://www.youtube.com/watch?v=V90zZxrh-JM</p>
                        <a href="https://www.youtube.com/watch?v=V90zZxrh-JM" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Перша книга, створена разом зі штучним інтелектом -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                37. Перша книга, створена разом зі штучним інтелектом
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">37.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Перша книга, створена разом зі штучним інтелектом: редактори видавництва "Ранок". URL: https://www.youtube.com/watch?v=ACbEsRjBVp4</p>
                        <a href="https://www.youtube.com/watch?v=ACbEsRjBVp4" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Піцик Т. І. Дидактичні ігри і цікаві творчі завдання на уроках читання -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                38. Піцик Т. І. Дидактичні ігри і цікаві творчі завдання на уроках читання
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">38.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Піцик Т. І. Дидактичні ігри і цікаві творчі завдання на уроках читання. Освітній проект «На урок». 2018. URL: https://naurok.com.ua/materiali-do-urokiv-didaktichni-igri-ta-cikavi-tvorchi-zavdannya-na-urokah-literaturnogo-chitannya-75424.html</p>
                        <a href="https://naurok.com.ua/materiali-do-urokiv-didaktichni-igri-ta-cikavi-tvorchi-zavdannya-na-urokah-literaturnogo-chitannya-75424.html" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Радченко В. Формування навичок читання молодших школярів шляхом впровадження методики  І.Т. Федоренка -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                39. Радченко В. Формування навичок читання молодших школярів шляхом впровадження методики  І.Т. Федоренка
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">39.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Радченко В. Формування навичок читання молодших школярів шляхом впровадження методики  І.Т. Федоренка. URL: https://radchenkov.wordpress.com/%D1%84%D0%BE%D1%80%D0%BC%D1%83%D0%B2%D0%B0%D0%BD%D0%BD%D1%8F-%D0%BD%D0%B0%D0%B2%D0%B8%D1%87%D0%BE%D0%BA-%D1%87%D0%B8%D1%82%D0%B0%D0%BD%D0%BD%D1%8F-%D0%BC%D0%BE%D0%BB%D0%BE%D0%B4%D1%88%D0%B8%D1%85/</p>
                        <a href="https://radchenkov.wordpress.com/%D1%84%D0%BE%D1%80%D0%BC%D1%83%D0%B2%D0%B0%D0%BD%D0%BD%D1%8F-%D0%BD%D0%B0%D0%B2%D0%B8%D1%87%D0%BE%D0%BA-%D1%87%D0%B8%D1%82%D0%B0%D0%BD%D0%BD%D1%8F-%D0%BC%D0%BE%D0%BB%D0%BE%D0%B4%D1%88%D0%B8%D1%85/" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ребус-метод -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                40. Ребус-метод
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">40.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Ребус-метод. URL: www.rebusmetod.com/#opys-metodyky</p>
                        <a href="http://www.rebusmetod.com/#opys-metodyky" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Робота з дитячою книжкою «Читаю сам» -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                41. Робота з дитячою книжкою «Читаю сам»
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">41.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Робота з дитячою книжкою «Читаю сам». Освітній проект «На урок». 2018.  URL: https://www.youtube.com/watch?time_continue=612&v=dO_mQitw15k</p>
                        <a href="https://www.youtube.com/watch?time_continue=612&v=dO_mQitw15k" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Серажим К. С. Сутність і природа інтерпретації тексту -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                42. Серажим К. С. Сутність і природа інтерпретації тексту
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">42.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Серажим К. С. Сутність і природа інтерпретації тексту. URL: http://journlib.univ.kiev.ua/index.php?act=article&article=2342</p>
                        <a href="http://journlib.univ.kiev.ua/index.php?act=article&article=2342" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ступка Б. Вірш Л. Костенко «Крила» -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                43. Ступка Б. Вірш Л. Костенко «Крила»
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">43.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Ступка Б. Вірш Л. Костенко «Крила». 2012. URL:  https://www.youtube.com/watch?v=kkHMxXsnE5k&t=18s</p>
                        <a href="https://www.youtube.com/watch?v=kkHMxXsnE5k&t=18s" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Українець І.  Ти відчуваєш дощ -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                44. Українець І.  Ти відчуваєш дощ
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">44.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Українець І.  Ти відчуваєш дощ. 2018. URL: https://www.youtube.com/watch?v=TGL7r0A2xPE</p>
                        <a href="https://www.youtube.com/watch?v=TGL7r0A2xPE" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Швидкість читання -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                45. Швидкість читання
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">45.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">47.1. Як підвищити швидкість читання. PRINTSTORE GROUP : вебсайт. URL: http://printstore.com.ua/sposobi-yaki-dopomagayut-pidvishhiti-shvidkist-chitannya/.</p>
                        <a href="http://printstore.com.ua/sposobi-yaki-dopomagayut-pidvishhiti-shvidkist-chitannya/" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">45.2</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">47.2. Техніка швидкого читання: поради та онлайн-тренажери. Buki. URL : https://buki.com.ua/news/shvydkochytannya/</p>
                        <a href="https://buki.com.ua/news/shvydkochytannya/" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">45.3</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">47.3. Cкорочитання для дітей – як навчити дитину швидко читати. Unicorn School. URL: https://unicorn.itstep.org/blog/short-reading-for-children-how-to-teach-a-child-to-read-quickly</p>
                        <a href="https://unicorn.itstep.org/blog/short-reading-for-children-how-to-teach-a-child-to-read-quickly" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">45.4</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">47.4. Майстер-клас із формування навичок швидкого читання "Вчимося читати швидко". URL:  https://youtu.be/T0okJAIrugQ</p>
                        <a href="https://youtu.be/T0okJAIrugQ" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Як виховати в дитині читача? Своїми лайфхаками ділиться генеральний директор "Ранку" Віктор Круглов -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">
                46. Як виховати в дитині читача? Своїми лайфхаками ділиться генеральний директор "Ранку" Віктор Круглов
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-sm font-medium text-blue-600 bg-white px-2 py-1 rounded-full">46.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Як виховати в дитині читача? Своїми лайфхаками ділиться генеральний директор "Ранку" Віктор Круглов. URL: https://www.youtube.com/watch?v=6ybG7Swvbzo&list=PL7w9d-B_UG-vYnHyRyhQf4xuny3Ks-QFz</p>
                        <a href="https://www.youtube.com/watch?v=6ybG7Swvbzo&list=PL7w9d-B_UG-vYnHyRyhQf4xuny3Ks-QFz" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Методичні матеріали та наукові роботи -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-orange-200 pb-2">
                4. Методичні матеріали та наукові роботи
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Блог вчителя О. Мацюк "Порушення читання та письма". 2017.</p>
                        <a href="http://oksanalogoped.blogspot.com/2017/01/blog-post.html" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути блог →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.2</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Богатко С. "З досвіду роботи «Розвиток читацької компетентності молодших школярів»".</p>
                        <a href="https://naurok.com.ua/z-dosvidu-roboti-rozvitok-chitacko-kompetentnosti-molodshih-shkolyariv-18128.html" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути статтю →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.3</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Бойко І. М. "Дидактичні ігри на уроці читання". Освітній портал «Super-urok.ua». 2024.</p>
                        <a href="https://super.urok-ua.com/didaktichni-igri-na-urotsi-chitannya/" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.4</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Бондаренко О. "Формування читацької компетентності молодших школярів".</p>
                        <a href="http://ukped.com/statti/teorija-navchannja/5080-formuvannia-chytatskoi-kompetentnosti-molodshykh-shkoliariv.html" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути статтю →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.5</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Влащук І. "Ігри та вправи, що сприяють формуванню і вдосконаленню навичок читання". Все для учителя. 2018.</p>
                        <a href="https://www.youtube.com/watch?v=EcKt1SJW8Mk" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути відео →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.6</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Дощенко Т. "Формування навички швидкого, свідомого читання молодших школярів на основі використання методик відомих науковців".</p>
                        <a href="https://ru.calameo.com/read/003505021f7f012af172e" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.7</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Дроздовський Д. "Нова українська школа як школа читання".</p>
                        <a href="https://day.kyiv.ua/uk/blog/suspilstvo/nova-ukrayinska-shkola-yak-shkola-chytannya" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути статтю →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.8</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Дроздовський Д. "Українська школа майбутнього твориться уже сьогодні: виклики й загрози реформування".</p>
                        <a href="http://slovoprosvity.org/2017/08/31/ukrajinska-shkola-majbutnoho-tvorytsya-uzhe-sohodni-vyklyky-j-zahrozy-reformuvannya/" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути статтю →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.9</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Заїка О. "Формування навички свідомого читання у молодших школярів як передумова успішного навчання в основній школі".</p>
                        <a href="https://ukrlit.net/article1/1797.html" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути статтю →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <span class="text-sm font-medium text-orange-600 bg-white px-2 py-1 rounded-full">4.10</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Манзюк Т. М. "Розвиток навичок читання".</p>
                        <a href="https://vseosvita.ua/library/rozvitok-navicok-citanna-molodsih-skolariv-5657.html" target="_blank" class="text-orange-600 hover:text-orange-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Практичні вправи та ігри -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-teal-200 pb-2">
                6. Практичні вправи та ігри для розвитку навичок
            </h3>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 p-3 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <span class="text-sm font-medium text-teal-600 bg-white px-2 py-1 rounded-full">6.1</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Вправи для розвитку техніки читання. Захопливе навчання з книжковою крамничкою.</p>
                        <a href="https://www.youtube.com/watch?v=8vEKAhxiRGM" target="_blank" class="text-teal-600 hover:text-teal-800 underline text-sm">Переглянути відео →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <span class="text-sm font-medium text-teal-600 bg-white px-2 py-1 rounded-full">6.2</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Вчимося читати швидко. 2017.</p>
                        <a href="https://youtu.be/T0okJAIrugQ" target="_blank" class="text-teal-600 hover:text-teal-800 underline text-sm">Переглянути майстер-клас →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <span class="text-sm font-medium text-teal-600 bg-white px-2 py-1 rounded-full">6.3</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Піцик Т. І. "Дидактичні ігри і цікаві творчі завдання на уроках читання". Освітній проект «На урок». 2018.</p>
                        <a href="https://naurok.com.ua/materiali-do-urokiv-didaktichni-igri-ta-cikavi-tvorchi-zavdannya-na-urokah-literaturnogo-chitannya-75424.html" target="_blank" class="text-teal-600 hover:text-teal-800 underline text-sm">Переглянути матеріал →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <span class="text-sm font-medium text-teal-600 bg-white px-2 py-1 rounded-full">6.4</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Робота з дитячою книжкою «Читаю сам». Освітній проект «На урок». 2018.</p>
                        <a href="https://www.youtube.com/watch?time_continue=612&v=dO_mQitw15k" target="_blank" class="text-teal-600 hover:text-teal-800 underline text-sm">Переглянути відео →</a>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 p-3 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <span class="text-sm font-medium text-teal-600 bg-white px-2 py-1 rounded-full">6.5</span>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Ребус-метод.</p>
                        <a href="http://www.rebusmetod.com/#opys-metodyky" target="_blank" class="text-teal-600 hover:text-teal-800 underline text-sm">Переглянути метод →</a>
                    </div>
                </div>
            </div>
        </div>
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