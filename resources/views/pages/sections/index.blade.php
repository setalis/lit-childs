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
        background: linear-gradient(135deg, #3A6EA5 0%, #2C5A8A 100%);
        color: white;
        padding: 1.5rem 2rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .section-header:hover {
        background: linear-gradient(135deg, #2C5A8A 0%, #1E4A7A 100%);
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
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="page-header">
        <h1 class="page-title">ЗМІСТ ПІДРУЧНИКА</h1>
        <p class="page-subtitle">Повна структура навчального матеріалу з теоретичними та практичними блоками</p>
    </div>

    @if($sections->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-lg" role="alert">
            <p class="font-bold text-lg">Розділи не знайдено</p>
            <p>На жаль, на даний момент у підручнику немає доступних розділів. Будь ласка, спробуйте зайти пізніше.</p>
        </div>
    @else
        <div class="sections-list">
            @foreach($sections as $section)
                <div class="section-container">
                    <div class="section-header" onclick="toggleSection({{ $section->id }})">
                        <h2 class="section-title">
                            {{ $section->title }}
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
                                    
                                    <div class="content-blocks">
                                        {{-- Теоретический материал --}}
                                        @if($subsection->theoryBlock)
                                            <a href="{{ route('blocks.theory.show', $subsection) }}" class="content-block">
                                                <div class="block-title">
                                                    📚 Теоретичний матеріал
                                                </div>
                                                <div class="block-description">
                                                    Основні поняття та теорія по темі
                                                </div>
                                            </a>
                                        @endif
                                        
                                        {{-- Практический материал --}}
                                        @if($subsection->practiceBlocks->isNotEmpty())
                                            <a href="{{ route('blocks.practice.all', $subsection) }}" class="content-block">
                                                <div class="block-title">
                                                    🛠️ Практичний матеріал
                                                </div>
                                                <div class="block-description">
                                                    Практичні завдання та вправи
                                                </div>
                                            </a>
                                        @endif
                                        
                                        {{-- Задания для самостоятельной работы --}}
                                        @if($subsection->homeworkBlock)
                                            <a href="{{ route('blocks.homework.show', $subsection) }}" class="content-block">
                                                <div class="block-title">
                                                    📝 Завдання для самостійної роботи
                                                </div>
                                                <div class="block-description">
                                                    Домашні завдання та самостійна робота
                                                </div>
                                            </a>
                                        @endif
                                        
                                        {{-- Средства контроля --}}
                                        @if($subsection->controlBlocks->isNotEmpty())
                                            <a href="{{ route('subsections.show', $subsection) }}/control" class="content-block">
                                                <div class="block-title">
                                                    ✅ Засоби контролю
                                                </div>
                                                <div class="block-description">
                                                    Тести та контрольні завдання
                                                </div>
                                            </a>
                                        @endif
                                    </div>
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