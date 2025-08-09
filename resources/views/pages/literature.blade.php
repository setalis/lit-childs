@extends('layouts.app')

@section('title', ' - Schoolbook')

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Література</h1>
            <h2 class="text-xl font-bold mb-4">Наукові джерела та методичні матеріали</h2>
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
        <h2 class="text-2xl font-bold text-[#28569A] mb-6">Наукові джерела та методичні матеріали</h2>
        
        {{-- Раздел 1: Методика преподавания украинского языка и литературы --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-blue-200 pb-2">1. Методика навчання української мови та літератури</h3>
            <div class="space-y-3">
                <div class="bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors p-3">
                    <span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">1.1</span>
                    <p class="text-blue-800 font-medium">Акімова Н., Акімова А. Розуміння тексту як специфічний тип розуміння. Психолінгвістика. 2018. 24 (1) С. 27–46.</p>
                    <a href="https://doi.org/10.31470/2309-1797-2018-24-1-27-46" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline text-sm">Переглянути статтю →</a>
                </div>
                
                <div class="bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors p-3">
                    <span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">1.2</span>
                    <p class="text-blue-800 font-medium">Арешенков Ю. О. Лінгвістичний аналіз художнього тексту. Кривий Ріг : Видавничий дім, 2007. 178 с.</p>
                    <a href="http://elibrary.kdpu.edu.ua/jspui/bitstream/0564/2123/1/лат.pdf" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline text-sm">Завантажити PDF →</a>
                </div>
                
                <div class="bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors p-3">
                    <span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">1.3</span>
                    <p class="text-blue-800 font-medium">Башманівська Л. А. Методика навчання української літератури: від теорії до практики: навчально-методичний посібник. Житомир: вид-во ЖДУ ім. І. Франка, 2024. 148 с.</p>
                    <a href="http://eprints.zu.edu.ua/39117/1/%D0%91%D0%B0%D1%88%D0%BC.%20%D0%9C%D0%B5%D1%82%D0%BE%D0%B4.%D0%BF%D0%BE%D1%81%D1%96%D0%B1.%202024.pdf" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
                
                <div class="bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors p-3">
                    <span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">1.4</span>
                    <p class="text-blue-800 font-medium">Білявська Т. М. Методика навчання літературного читання : навч.-метод. посібн. Миколаїв : СПД Румянцева, 2017. 109 с.</p>
                    <a href="http://dspace.mdu.edu.ua/jspui/bitstream/123456789/330/3/%D0%91%D1%96%D0%BB%D1%8F%D0%B2%D1%81%1%8C%D0%BA%D0%B0_%D0%9C%D0%B5%D1%82%D0%BE%D0%B4%D0%B8%D0%BA%D0%B0%20%D0%BD%D0%B0%D0%B2%D1%87%D0%B0%D0%BD%D0%BD%D1%8F%20%D0%BB%D1%96%D1%82%D0%B5%D1%80%D0%B0%D1%82%D1%83%D1%80%D0%BD%D0%BE%D0%B3%D0%BE%20%D1%87%D0%B8%D1%82%D0%B0%D0%BD%D0%BD%D1%8F%2C%202017.pdf" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
                
                <div class="bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors p-3">
                    <span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">1.5</span>
                    <p class="text-blue-800 font-medium">Вашуленко М. С. Нова українська школа : методика навчання інтегрованого курсу «Українська мова» у 1–2 класах закладів загальної середньої освіти на засадах компетентнісного підходу. Київ : Видавничий дім «Освіта», 2019. 192 с.</p>
                    <a href="https://lib.imzo.gov.ua/wa-data/public/site/books2/navchalno-metodychny-posibnyky/dlya-pedpraytsivnykiv/Ukr_Mov+movlennia_Vashulenko_2019.pdf" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
            </div>
        </div>

        {{-- Раздел 2: Психология и педагогика --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-green-200 pb-2">2. Психологія та педагогіка</h3>
            <div class="space-y-3">
                <div class="bg-green-50 rounded-lg hover:bg-green-100 transition-colors p-3">
                    <span class="inline-block bg-green-200 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">2.1</span>
                    <p class="text-green-800 font-medium">Дуткевич Т. В. Дитяча психологія : навч. посібн. Київ : Центр учбової літератури, 2012. 424 с.</p>
                    <a href="https://shron1.chtyvo.org.ua/Dutkevych_Tetiana/Dytiacha_psykholohiia.pdf" target="_blank" class="text-green-600 hover:text-green-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
                
                <div class="bg-green-50 rounded-lg hover:bg-green-100 transition-colors p-3">
                    <span class="inline-block bg-green-200 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">2.2</span>
                    <p class="text-green-800 font-medium">Зайченко І.В. Педагогіка : навчальний посібник для студентів вищих педагогічних навчальних закладів, 2-е вид. Київ : "Освіта України", "КНТ", 2008. 528 с.</p>
                    <a href="https://kipt.com.ua/wp-content/uploads/2018/12/Pedagogika_Zaychenko.pdf" target="_blank" class="text-green-600 hover:text-green-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
                
                <div class="bg-green-50 rounded-lg hover:bg-green-100 transition-colors p-3">
                    <span class="inline-block bg-green-200 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">2.3</span>
                    <p class="text-green-800 font-medium">Токарева Н. М., Шамне А. В. Вікова та педагогічна психологія : навчальний посібник для студентів ВНЗ. Київ : НУБіП, 2017. 548 с.</p>
                    <a href="http://elibrary.kdpu.edu.ua/xmlui/handle/0564/1425" target="_blank" class="text-green-600 hover:text-green-800 hover:underline text-sm">Переглянути матеріал →</a>
                </div>
                
                <div class="bg-green-50 rounded-lg hover:bg-green-100 transition-colors p-3">
                    <span class="inline-block bg-green-200 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">2.4</span>
                    <p class="text-green-800 font-medium">Сергєєнкова О. П., Столярчук О. А., Коханова О. П., Пасєка О. В. Загальна психологія : навчальний посібник. Київ : Центр учбової літератури, 2012. 296 с.</p>
                    <a href="https://pidruchniki.com/13820328/psihologiya/vidi_movlennya_harakteristika" target="_blank" class="text-green-600 hover:text-green-800 hover:underline text-sm">Переглянути посібник →</a>
                </div>
            </div>
        </div>

        {{-- Раздел 3: Теория литературы и литературоведение --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-purple-200 pb-2">3. Теорія літератури та літературознавство</h3>
            <div class="space-y-3">
                <div class="bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors p-3">
                    <span class="inline-block bg-purple-200 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">3.1</span>
                    <p class="text-purple-800 font-medium">Гром'як Р. Т., Ковалів Ю. І., Теремко В. І. Літературознавчий словник-довідник. Київ : ВЦ «Академія», 2007. 752 с.</p>
                    <p class="text-purple-600 text-sm">Довідкове видання</p>
                </div>
                
                <div class="bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors p-3">
                    <span class="inline-block bg-purple-200 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">3.2</span>
                    <p class="text-purple-800 font-medium">Теорія літератури : навчальний посібник /А. В. Горбань. Житомир : ЖДУ імені Івана Франка, 2020. 233 c.</p>
                    <a href="http://eprints.zu.edu.ua/32259/7/TL-Horban.pdf" target="_blank" class="text-purple-600 hover:text-purple-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
                
                <div class="bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors p-3">
                    <span class="inline-block bg-purple-200 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">3.3</span>
                    <p class="text-purple-800 font-medium">Ференц Н. С. Основи літературознавства : підручник. Київ : Знання, 2011. 431 с.</p>
                    <p class="text-purple-600 text-sm">Навчальний матеріал</p>
                </div>
                
                <div class="bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors p-3">
                    <span class="inline-block bg-purple-200 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">3.4</span>
                    <p class="text-purple-800 font-medium">Франко Іван. Із секретів поетичної творчості.</p>
                    <a href="http://ukrlit.org/faily/avtor/franko_ivan_yakovych/franko-iz_sekretiv_poetychnoii_tvorchosti.pdf" target="_blank" class="text-purple-600 hover:text-purple-800 hover:underline text-sm">Завантажити текст →</a>
                </div>
            </div>
        </div>

        {{-- Раздел 4: Детская литература и чтение --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-orange-200 pb-2">4. Дитяча література та читання</h3>
            <div class="space-y-3">
                <div class="bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors p-3">
                    <span class="inline-block bg-orange-200 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">4.1</span>
                    <p class="text-orange-800 font-medium">Богданець-Білоскаленко Н. Ознайомлення дітей з пізнавальними текстами. Освітній журнал фонду Просвіта. Актуальне. Методика. Матеріали. Статистика. Історія. 2023. № 4. С. 45–51.</p>
                    <a href="https://lib.iitta.gov.ua/id/eprint/738777/1/Bogdanets-Bilosk.%20N..pdf" target="_blank" class="text-orange-600 hover:text-orange-800 hover:underline text-sm">Завантажити статтю →</a>
                </div>
                
                <div class="bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors p-3">
                    <span class="inline-block bg-orange-200 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">4.2</span>
                    <p class="text-orange-800 font-medium">Джежелей О. В., Ємець А. А., Коваленко О. М. Класна бібліотека. Робота з дитячою книжкою. 1 клас. Харків : Видавничий дім "Весна", 2019. 38 с.</p>
                    <a href="https://vesna-books.com.ua/wp-content/uploads/2020/04/Klasna-biblioteka_Robota-z-dytyachoyu-knyzhkoyu_1-klas_Metodychka.pdf" target="_blank" class="text-orange-600 hover:text-orange-800 hover:underline text-sm">Завантажити методичку →</a>
                </div>
                
                <div class="bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors p-3">
                    <span class="inline-block bg-orange-200 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">4.3</span>
                    <p class="text-orange-800 font-medium">Дитячі освітні видання: історія та класифікація : навч. посіб. / Надія Миколаївна Миколаєнко. Житомир : Видавець О.О. Євенок, 2018. 84 с.</p>
                    <p class="text-orange-600 text-sm">Навчальний посібник</p>
                </div>
                
                <div class="bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors p-3">
                    <span class="inline-block bg-orange-200 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">4.4</span>
                    <p class="text-orange-800 font-medium">Кизилова В. В. Українська література для дітей та юнацтва: новітній дискурс : навчально-методичний посібник для студ. вищих навч. закл. Старобільськ : Вид-во ДЗ «Луганський національний університет імені Тараса Шевченка», 2015. 236 с.</p>
                    <a href="https://dspace.luguniv.edu.ua/xmlui/bitstream/handle/123456789/207/Ukrainska%20liyeratura%20dlya%20ditey%20ta%20unactva.pdf?sequence=1&isAllowed=y" target="_blank" class="text-orange-600 hover:text-orange-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
            </div>
        </div>

        {{-- Раздел 5: Современные технологии и инновации --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-indigo-200 pb-2">5. Сучасні технології та інновації</h3>
            <div class="space-y-3">
                <div class="bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors p-3">
                    <span class="inline-block bg-indigo-200 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">5.1</span>
                    <p class="text-indigo-800 font-medium">Арт-технології : навчально-методичний посібник / Уклад.: О.А.Мірошниченко. Житомир : ТОВ «Видавничий дім Бук-Друк», 2024. 180 с.</p>
                    <a href="http://eprints.zu.edu.ua/41023/1/art-technologies.pdf" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
                
                <div class="bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors p-3">
                    <span class="inline-block bg-indigo-200 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">5.2</span>
                    <p class="text-indigo-800 font-medium">Бескорса О.С., Моторіна Д.А. Інноваційні технології навчання читання у практиці сучасної початкової школи. Інноваційна педагогіка. Вип. 12. Т. 1. 2019. С. 23–26.</p>
                    <a href="http://www.innovpedagogy.od.ua/archives/2019/12/part_1/6.pdf" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline text-sm">Завантажити статтю →</a>
                </div>
                
                <div class="bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors p-3">
                    <span class="inline-block bg-indigo-200 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">5.3</span>
                    <p class="text-indigo-800 font-medium">Кузілова Т. М. Імерсивні технології в роботі бібліотек для дітей: метод. лист. Київ, 2021. 20 с.</p>
                    <a href="https://chl.kiev.ua/mbm/MBM/%D1%82%D0%B5%D0%BA%D1%81%D1%82%D0%B8/2021/%D0%86%D0%BC%D0%B5%D1%80%D1%81%D0%B8%D0%B2%D0%BD%D1%96%20%D1%82%D0%B5%D1%85%D0%BD%D0%BE%D0%BB%D0%BE%D0%B3%D1%96%D1%97.pdf" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline text-sm">Завантажити матеріал →</a>
                </div>
                
                <div class="bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors p-3">
                    <span class="inline-block bg-indigo-200 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">5.4</span>
                    <p class="text-indigo-800 font-medium">Потапенко І. STEM-освіта в початковій школі: від навчальної моделі до реального уроку /за заг. ред. О. Елькіна, О. Масалітіної; упор. К. Ремез. Київ: ГО «EdCamp Ukraine», 2023. 300 с.</p>
                    <a href="https://drive.google.com/file/d/1H0_bLI86iaHWCoBqVsLXF59iGJ2cFoxv/view?fbclid=IwAR0dDyPFBTBPbPE-LqDvQC7YNeDcKfyjvZS_ubnVNEPYac5y93G-OCHm6EY" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline text-sm">Завантажити посібник →</a>
                </div>
            </div>
        </div>

        {{-- Раздел 6: Исследования и аналитика --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-teal-200 pb-2">6. Дослідження та аналітика</h3>
            <div class="space-y-3">
                <div class="bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors p-3">
                    <span class="inline-block bg-teal-200 text-teal-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">6.1</span>
                    <p class="text-teal-800 font-medium">Волосевич І., Шуренкова А. Звіт за результатами всеукраїнського соціологічного дослідження "Читання в контексті медіаспоживання та життєконструювання" відповідно до договору № 81 від 10 липня 2020 року на замовлення державної установи "Український інститут книги". Київ, 2020. 181 с.</p>
                    <a href="https://ubi.org.ua/uk/news/kategoriya-2/uik-oprilyudniv-rezultati-doslidzhennya-chitannya-v-konteksti-mediaspozhivannya-ta-zhitt-konstruyuvannya-dokument" target="_blank" class="text-teal-600 hover:text-teal-800 hover:underline text-sm">Переглянути звіт →</a>
                </div>
                
                <div class="bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors p-3">
                    <span class="inline-block bg-teal-200 text-teal-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">6.2</span>
                    <p class="text-teal-800 font-medium">Національний звіт за результатами міжнародного дослідження якості освіти PISA-2018. Київ : УЦОЯО. 2019. 439 с.</p>
                    <a href="https://testportal.gov.ua/wp-content/uploads/2019/12/PISA_2018_Report_UKR.pdf" target="_blank" class="text-teal-600 hover:text-teal-800 hover:underline text-sm">Завантажити звіт →</a>
                </div>
                
                <div class="bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors p-3">
                    <span class="inline-block bg-teal-200 text-teal-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">6.3</span>
                    <p class="text-teal-800 font-medium">Національний звіт за результатами міжнародного дослідження якості освіти PISA-2022 / кол. авт. : Г. Бичко (осн. автор), Т. Вакуленко, Т. Лісова, М. Мазорчук, В. Терещенко, С. Раков, В. Горох та ін. ; за ред. В. Терещенка та І. Клименко ; Український центр оцінювання якості освіти. Київ, 2023. 395 с.</p>
                    <a href="https://pisa.testportal.gov.ua/wp-content/uploads/2023/12/PISA-2022_Naczionalnyj-zvit_povnyj.pdf" target="_blank" class="text-teal-600 hover:text-teal-800 hover:underline text-sm">Завантажити звіт →</a>
                </div>
                
                <div class="bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors p-3">
                    <span class="inline-block bg-teal-200 text-teal-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">6.4</span>
                    <p class="text-teal-800 font-medium">Діагностика та компенсація освітніх втрат у загальній середній освіті України / кол. автор.; за загальною редакцією О. М. Топузова; укл. М. В. Головко. Київ : Педагогічна думка, 2023. 187 с.</p>
                    <a href="https://doi.org/10.32405/978-966-644-736-7-2023-190" target="_blank" class="text-teal-600 hover:text-teal-800 hover:underline text-sm">Переглянути матеріал →</a>
                </div>
            </div>
        </div>

        {{-- Раздел 7: Словари и справочники --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-red-200 pb-2">7. Словники та довідники</h3>
            <div class="space-y-3">
                <div class="bg-red-50 rounded-lg hover:bg-red-100 transition-colors p-3">
                    <span class="inline-block bg-red-200 text-red-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">7.1</span>
                    <p class="text-red-800 font-medium">Гончаренко С. Український педагогічний словник. Київ : Либідь, 1997. 373 с.</p>
                    <p class="text-red-600 text-sm">Довідкове видання</p>
                </div>
                
                <div class="bg-red-50 rounded-lg hover:bg-red-100 transition-colors p-3">
                    <span class="inline-block bg-red-200 text-red-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">7.2</span>
                    <p class="text-red-800 font-medium">Коломієць І. І. Основні лінгвостилістичні поняття і категорії (словник-довідник філолога). Умань : ВПЦ «Візаві», 2015. 202 с.</p>
                    <a href="https://dspace.udpu.edu.ua/bitstream/6789/3335/1/Slovnyk-dovidnyk_zi_stylistyky.pdf" target="_blank" class="text-red-600 hover:text-red-800 hover:underline text-sm">Завантажити словник →</a>
                </div>
                
                <div class="bg-red-50 rounded-lg hover:bg-red-100 transition-colors p-3">
                    <span class="inline-block bg-red-200 text-red-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">7.3</span>
                    <p class="text-red-800 font-medium">Наумчук М. М. Словник-довідник основних термінів і понять з методики української мови. Тернопіль : Астон, 2003. 132 с.</p>
                    <p class="text-red-600 text-sm">Довідкове видання</p>
                </div>
                
                <div class="bg-red-50 rounded-lg hover:bg-red-100 transition-colors p-3">
                    <span class="inline-block bg-red-200 text-red-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">7.4</span>
                    <p class="text-red-800 font-medium">Словник української мови. Академічний тлумачний словник (1970–1980).</p>
                    <a href="https://sum.in.ua/" target="_blank" class="text-red-600 hover:text-red-800 hover:underline text-sm">Перейти до словника →</a>
                </div>
            </div>
        </div>

        {{-- Раздел 8: Международные исследования --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 border-b-2 border-yellow-200 pb-2">8. Міжнародні дослідження</h3>
            <div class="space-y-3">
                <div class="bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors p-3">
                    <span class="inline-block bg-yellow-200 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">8.1</span>
                    <p class="text-yellow-800 font-medium">21st-Century Readers: Developing Literacy Skills in a Digital World. Paris: PISA, OECD Publishing, 2021. 214 р.</p>
                    <a href="https://doi.org/10.1787/a83d84cb-en" target="_blank" class="text-yellow-600 hover:text-yellow-800 hover:underline text-sm">Переглянути дослідження →</a>
                </div>
                
                <div class="bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors p-3">
                    <span class="inline-block bg-yellow-200 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">8.2</span>
                    <p class="text-yellow-800 font-medium">Singer, L., & Alexander, Р. (2016). Reading Across Mediums: Effects of Reading Digital and Print Texts on Comprehension and Calibration. The Journal of Experimental Education, 85(1), 155–172.</p>
                    <a href="http://doi.org/10.1080/00220973.2016.1143794" target="_blank" class="text-yellow-600 hover:text-yellow-800 hover:underline text-sm">Переглянути статтю →</a>
                </div>
                
                <div class="bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors p-3">
                    <span class="inline-block bg-yellow-200 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full mr-2">8.3</span>
                    <p class="text-yellow-800 font-medium">Singer, L., Alexander, P.A., & Sun, Yu. (2023). The Effects of Processing Multimodal Texts in Print and Digitally on Comprehension and Calibration. The Journal of Experimental Education, 91(4), 599–620.</p>
                    <a href="http://doi.org/10.1080/00220973.2022.2092831" target="_blank" class="text-yellow-600 hover:text-yellow-800 hover:underline text-sm">Переглянути статтю →</a>
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