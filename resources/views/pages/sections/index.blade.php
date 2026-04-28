@extends('layouts.app')

@section('title', 'Зміст підручника - Schoolbook')

@push('styles')
<style>
    .section-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .section-header {
        color: white;
        padding: 1.5rem 2rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .section-header:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    
    /* Цвета для разных разделов */
    .section-header.color-1 {
        background: linear-gradient(135deg, #3A6EA5 0%, #2C5A8A 100%);
    }
    
    .section-header.color-2 {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }
    
    .section-header.color-3 {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    }
    
    .section-header.color-4 {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    }
    
    .section-header.color-5 {
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    }
    
    .section-header.color-6 {
        background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);
    }
    
    .section-header.color-7 {
        background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%);
    }
    
    .section-header.color-8 {
        background: linear-gradient(135deg, #84CC16 0%, #65A30D 100%);
    }
    
    .section-header.color-9 {
        background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
    }
    
    .section-header.color-10 {
        background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
    }
    
    /* Стили для аккордеона */
    [data-accordion-target] {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        color: white;
        transition: background 0.3s ease;
    }
    
    [data-accordion-target][aria-expanded="true"] {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .section-toggle {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .section-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }
    
    .section-toggle.rotated {
        transform: rotate(180deg);
    }
    
    .section-content {
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .section-content.expanded {
        max-height: none;
        padding: 2rem;
    }
    
    .subsection-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #3A6EA5;
        transition: all 0.3s ease;
    }
    
    .subsection-item:hover {
        background: #f1f5f9;
        transform: translateX(4px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .subsection-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        display: block;
        text-decoration: none;
    }
    
    .subsection-title:hover {
        color: #3A6EA5;
    }
    
    .content-blocks {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .content-block {
        background: white;
        border-radius: 6px;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .content-block:hover {
        border-color: #3A6EA5;
        box-shadow: 0 2px 8px rgba(58, 110, 165, 0.15);
        transform: translateY(-2px);
    }
    
    .block-icon {
        width: 24px;
        height: 24px;
        margin-right: 0.5rem;
        vertical-align: middle;
    }
    
    .block-title {
        font-weight: 600;
        color: #3A6EA5;
        margin-bottom: 0.25rem;
    }
    
    .block-description {
        font-size: 0.875rem;
        color: #64748b;
        line-height: 1.4;
    }
    
    .no-content {
        color: #94a3b8;
        font-style: italic;
        text-align: center;
        padding: 1rem;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #3A6EA5;
        margin-bottom: 1rem;
    }
    
    .page-subtitle {
        font-size: 1.125rem;
        color: #64748b;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="flex flex-col items-center justify-center border-b border-yellow-500 ">
    <div class="container flex flex-col md:flex-row mx-auto lg:px-8 px-4">
        <div class="w-3/4 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4 uppercase text-[#28569A]">Зміст підручника</h1>
            <h2 class="text-xl font-bold mb-4 uppercase">Повна структура навчального матеріалу з теоретичними та практичними блоками</h2>
        </div>
        <div class="w-1/4 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/header-1.png') }}" alt="Section 1" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
<div id="accordion-collapse" data-accordion="collapse" class="w-full mb-8">
    <h2 id="accordion-collapse-heading-1">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right rounded-t-xl bg-amber-500 shadow-xl px-8" data-accordion-target="#accordion-collapse-body-1" aria-expanded="false" aria-controls="accordion-collapse-body-1">
        <span class="section-title uppercase font-bold font-xl !font-serif">Передмова</span>
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-500 ">
                <svg data-accordion-icon class="w-4 h-4 rotate-180 shrink-0 transition-all duration-300" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
            </div>
        </button>
    </h2>
    <div id="accordion-collapse-body-1" class="hidden rounded-xl bg-white shadow-xl" aria-labelledby="accordion-collapse-heading-1">
        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
        <p class="mb-2 text-gray-500 dark:text-gray-400">Початкова школа є важливою ланкою літературної освіти, забезпечуючи базові знання, уміння та навички, що вможливлюють надалі ефективну читацьку діяльність на уроках літератури та опанування всіх інших освітніх галузей, адже читання з розумінням або усвідомлене читання в нормативних документах України та світу віднесено до наскрізних умінь особистості, що забезпечує доброякісність усієї її освітньої та суспільної діяльності.</p>
        <p class="mb-2 text-gray-500 dark:text-gray-400">Навчальна дисципліна «Дитяча література з методикою навчання літературного читання» спрямована на формування в майбутніх учителів початкових класів повноцінного сприйняття літератури як мистецтва слова, розуміння специфіки дитячої літератури; розвиток навички оцінки й інтерпретації художніх творів; розкриття та усвідомлення здобувачами освіти сутності процесу навчання літературного читання в початковій школі відповідно до вимог Державного стандарту початкової освіти.</p>

        <p class="mb-2 text-gray-500 dark:text-gray-400">Украй вагомим для майбутнього педагога початкової школи, який у своєму професійному становленні має опанувати теоретичний та практичний базис методики навчання літературного читання, є знати і розуміти сутність сучасних тенденцій розвитку цієї науки. Цифровий підручник «Дитяча література з методикою навчання літературного читання» покликаний забезпечити ефективне опанування матеріалу через зручну навігацію та інтерактивні інструменти, що сприяють активній взаємодії здобувачів освіти з текстом і розвитку їхньої читацької компетентності.</p>

        <p class="mb-2 text-gray-500 dark:text-gray-400">Інтерактивна структура теоретичного матеріалу підручника, зокрема використання внутрішніх гіперпосилань на тексти науково-методичних джерел, збірники вправ і завдань із читання, літературні твори, аудіо- та відеозаписи з виконанням художніх творів та уроків (фрагментів уроків) літературного читання в початковій школі з обов'язковим зазначенням авторства та/або джерела; зовнішніх посилань, що пов'язані з текстами публікацій у наукових виданнях, які містяться на сайтах видавництв та/або мають DOI, а також нормативних документів та навчально-методичного забезпечення освітнього процесу на уроках літературного читання в початковій школі, які постійно оновлюються на сайтах МОН, ІМЗО та ін.: чинний Державний стандарт початкової освіти, Типові освітні та навчальні програми з читання (1–2 класи) і літературного читання (3–4 класи), підручники і посібники з грифом МОН тощо; рівневість практичних та самостійних завдань уможливлює легке вивчення навчального матеріалу, бо враховує принцип індивідуалізації та диференціації навчання: автономія здобувача освіти у виборі обсягу та траєкторії сприймання матеріалу, рівня та кількості завдань; а демократичність реалізується через включення ситуації вибору у зміст практичних і самостійних робіт, що надає змогу обирати ті завдання, які найбільше відповідають інтересам здобувачів освіти. У такий спосіб цифровий підручник «Дитяча література з методикою навчання літературного читання» надає змогу здобувачам вищої освіти самостійно поглиблювати знання, формувати критичне ставлення до інформації та вибудовувати власну освітню траєкторію відповідно до індивідуальних потреб і можливостей.</p>

        <p class="mb-2 text-gray-500 dark:text-gray-400">Цифровий підручник «Дитяча література з методикою навчання літературного читання» призначений для підготовки здобувачів вищої освіти спеціальності А3 Початкова освіта до професійної діяльності, оволодіння теоретичними знаннями та формування практичних умінь з організації освітнього процесу на уроках літературного читання в початковій школі.</p>

        </div>
    </div>  
</div>


                        @if($sections->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-lg" role="alert">
            <p class="font-bold text-lg">Розділи не знайдено</p>
            <p>На жаль, на даний момент у підручнику немає доступних розділів. Будь ласка, спробуйте зайти пізніше.</p>
        </div>
    @else
        <div class="sections-list">
            @foreach($sections as $index => $section)
                @php
                    $colorClass = 'color-' . (($index % 10) + 1);
                @endphp
                <div class="section-container">
                    <div class="section-header {{ $colorClass }}" onclick="toggleSection({{ $section->id }})">
                        <h2 class="section-title">
                            Розділ {{$section->order}}.  {{ $section->title }}
                            <button class="section-toggle" id="toggle-{{ $section->id }}">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                </svg>
                            </button>
                        </h2>
                    </div>

                    <div class="section-content" id="content-{{ $section->id }}">
                        @if($section->subsections->isEmpty())
                            <div class="no-content">
                                <p>У цьому розділі поки немає підрозділів</p>
                            </div>
                        @else
                            @foreach($section->subsections as $subsection)
                                <div class="subsection-item">
                                    <a href="{{ route('subsections.show', $subsection) }}" class="subsection-title">
                                        {{ $section->order }}.{{ $subsection->order }} {{ $subsection->title }}
                                    </a>

                                    @if($subsection->subSubsections->isNotEmpty())
                                        {{-- Підрозділ має під-підрозділи — показуємо їх список --}}
                                        <div class="mt-3 space-y-1">
                                            @foreach($subsection->subSubsections as $subSub)
                                                <div style="border-left: 3px solid #FFBB00; padding-left: 12px; margin-left: 4px;">
                                                    <a href="{{ route('subsections.show', $subSub) }}"
                                                       style="font-size: 0.9rem; color: #1e293b; text-decoration: none; display: block; padding: 4px 0;"
                                                       onmouseover="this.style.color='#3A6EA5'" onmouseout="this.style.color='#1e293b'">
                                                        <span style="color: #3A6EA5; font-weight: 600; margin-right: 6px;">
                                                            {{ $section->order }}.{{ $subsection->order }}.{{ $subSub->order }}
                                                        </span>
                                                        {{ $subSub->title }}
                                                    </a>
                                                    <div class="content-blocks" style="margin-top: 6px;">
                                                        @if($subSub->theoryBlock)
                                                            <a href="{{ route('blocks.theory.show', $subSub) }}" class="content-block">
                                                                <div class="block-title">📚 Теоретичний матеріал</div>
                                                                <div class="block-description">Основні поняття та теорія по темі</div>
                                                            </a>
                                                        @endif
                                                        @if($subSub->practiceBlocks->isNotEmpty())
                                                            <a href="{{ route('blocks.practice.all', $subSub) }}" class="content-block">
                                                                <div class="block-title">🛠️ Практичний матеріал</div>
                                                                <div class="block-description">Практичні завдання та вправи</div>
                                                            </a>
                                                        @endif
                                                        @if($subSub->homeworkBlock)
                                                            <a href="{{ route('blocks.homework.show', $subSub) }}" class="content-block">
                                                                <div class="block-title">📝 Самостійна робота</div>
                                                                <div class="block-description">Домашні завдання та самостійна робота</div>
                                                            </a>
                                                        @endif
                                                        @if($subSub->controlBlocks->isNotEmpty())
                                                            <a href="{{ route('blocks.control.all', $subSub) }}" class="content-block">
                                                                <div class="block-title">✅ Засоби контролю</div>
                                                                <div class="block-description">Тести та контрольні завдання</div>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        {{-- Звичайний підрозділ без під-підрозділів --}}
                                        <div class="content-blocks">
                                            @if($subsection->theoryBlock)
                                                <a href="{{ route('blocks.theory.show', $subsection) }}" class="content-block">
                                                    <div class="block-title">📚 Теоретичний матеріал</div>
                                                    <div class="block-description">Основні поняття та теорія по темі</div>
                                                </a>
                                            @endif
                                            @if($subsection->practiceBlocks->isNotEmpty())
                                                <a href="{{ route('blocks.practice.all', $subsection) }}" class="content-block">
                                                    <div class="block-title">🛠️ Практичний матеріал</div>
                                                    <div class="block-description">Практичні завдання та вправи</div>
                                                </a>
                                            @endif
                                            @if($subsection->homeworkBlock)
                                                <a href="{{ route('blocks.homework.show', $subsection) }}" class="content-block">
                                                    <div class="block-title">📝 Завдання для самостійної роботи</div>
                                                    <div class="block-description">Домашні завдання та самостійна робота</div>
                                                </a>
                                            @endif
                                            @if($subsection->controlBlocks->isNotEmpty())
                                                <a href="{{ route('blocks.control.all', $subsection) }}" class="content-block">
                                                    <div class="block-title">✅ Засоби контролю</div>
                                                    <div class="block-description">Тести та контрольні завдання</div>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
function toggleSection(sectionId) {
    const content = document.getElementById(`content-${sectionId}`);
    const toggle = document.getElementById(`toggle-${sectionId}`);
    
    if (content.classList.contains('expanded')) {
        content.classList.remove('expanded');
        toggle.classList.remove('rotated');
    } else {
        content.classList.add('expanded');
        toggle.classList.add('rotated');
    }
}

// Автоматически развернуть первый раздел при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    const firstSection = document.querySelector('.section-container');
    if (firstSection) {
        const sectionId = firstSection.querySelector('.section-header').getAttribute('onclick').match(/\d+/)[0];
        toggleSection(parseInt(sectionId));
    }
});
</script>
@endsection 