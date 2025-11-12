@extends('layouts.app')

@section('title', $test->title . ' - Schoolbook')

@push('styles')
<style>
    .test-header-bg {
        background-image: url("{{ asset('images/main-bg-1-1.png') }}"); 
        background-size: cover;
        background-position: center;
        padding: 4rem 0; 
        color: white; 
    }
    .question-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .question-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
    }
    .answer-option {
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .answer-option:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .answer-option.selected {
        border-color: #3b82f6;
        background-color: #dbeafe;
    }
    .matching-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-top: 1rem;
    }
    .matching-left, .matching-right {
        space-y: 0.5rem;
    }
    .matching-item {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .matching-item:hover {
        border-color: #3b82f6;
    }
    .matching-item.selected {
        border-color: #3b82f6;
        background-color: #dbeafe;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Заголовок теста --}}
    <section class="test-header-bg rounded-lg shadow-lg mb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3">{{ $test->title }}</h1>
            @if($test->description)
                <p class="text-lg sm:text-xl opacity-90">{!! $test->description !!}</p>
            @endif
            <div class="mt-4">
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm">
                    Питань: {{ $test->questions->count() }}
                </span>
            </div>
        </div>
    </section>

    {{-- Форма теста --}}
    <form action="{{ route('test.submit', $test) }}" method="POST" id="testForm">
        @csrf
        
        @foreach($test->questions as $index => $question)
            <div class="question-card">
                <div class="question-header">
                    <h3 class="text-xl font-semibold mb-2">
                        Питання {{ $index + 1 }}
                        <span class="text-sm opacity-75 ml-2">
                            ({{ $question->type_display }})
                        </span>
                    </h3>
                    <p class="text-lg">{!! $question->text !!}</p>
                </div>
                
                <div class="p-6">
                    @if($question->type === 'single_choice')
                        {{-- Одиночный выбор --}}
                        @foreach($question->answers as $answer)
                            <label class="answer-option block" onclick="selectSingleChoice(this)">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="hidden">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 radio-indicator"></div>
                                    <span>{{ $answer->text }}</span>
                                </div>
                            </label>
                        @endforeach

                    @elseif($question->type === 'multiple_choice')
                        {{-- Множественный выбор --}}
                        @foreach($question->answers as $answer)
                            <label class="answer-option block" onclick="toggleMultipleChoice(this)">
                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $answer->id }}" class="hidden">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 border-2 border-gray-300 rounded mr-3 checkbox-indicator"></div>
                                    <span>{{ $answer->text }}</span>
                                </div>
                            </label>
                        @endforeach

                    @elseif($question->type === 'fill_in_the_blank')
                        {{-- Дописать --}}
                        <div class="space-y-4">
                            @php
                                // Парсим текст вопроса для поиска пропусков [1], [2], etc.
                                preg_match_all('/\[(\d+)\]/', $question->text, $matches);
                                $blankNumbers = !empty($matches[1]) ? array_unique($matches[1]) : [1];
                                sort($blankNumbers, SORT_NUMERIC);
                                
                                // Получаем правильные ответы, отсортированные по blank_position
                                $correctAnswers = $question->answers->sortBy('blank_position');
                            @endphp
                            
                            @if(count($blankNumbers) > 1)
                                {{-- Множественные пропуски --}}
                                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <h4 class="font-semibold text-blue-800 mb-2">Заповніть пропуски в тексті:</h4>
                                    <div class="text-gray-700 mb-3">
                                        {!! preg_replace('/\[(\d+)\]/', '<span class="font-bold text-blue-600">[пропуск $1]</span>', $question->text) !!}
                                    </div>
                                </div>
                                
                                @foreach($blankNumbers as $index => $blankNumber)
                                    <div class="flex items-center space-x-3 mb-3">
                                        <label class="font-semibold text-gray-700 w-20">
                                            Пропуск {{ $blankNumber }}:
                                        </label>
                                        <input type="text" 
                                               name="answers[{{ $question->id }}][{{ $blankNumber }}]" 
                                               class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                               placeholder="Ваша відповідь для пропуску {{ $blankNumber }}...">
                                    </div>
                                @endforeach
                            @else
                                {{-- Один пропуск (старый формат) --}}
                                <input type="text" 
                                       name="answers[{{ $question->id }}]" 
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                                       placeholder="Введіть вашу відповідь...">
                            @endif
                        </div>

                    @elseif($question->type === 'matching')
                        {{-- Соответствие --}}
                        <div class="matching-container" id="matching-{{ $question->id }}">
                            <div class="matching-left">
                                <h4 class="font-semibold mb-3 text-center">Ліва частина</h4>
                                @foreach($question->matchPairs->whereNotNull('left_text') as $pair)
                                    <div class="matching-item left-item" 
                                         data-left="{{ $pair->left_text }}"
                                         onclick="selectMatchingItem(this, 'left', {{ $question->id }})">
                                        {{ $pair->left_text }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="matching-right">
                                <h4 class="font-semibold mb-3 text-center">Права частина</h4>
                                @if(isset($question->shuffled_right_items))
                                    {{-- Используем перемешанные элементы из контроллера --}}
                                    @foreach($question->shuffled_right_items as $rightText)
                                        <div class="matching-item right-item" 
                                             data-right="{{ $rightText }}"
                                             onclick="selectMatchingItem(this, 'right', {{ $question->id }})">
                                            {{ $rightText }}
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Fallback: используем исходный порядок --}}
                                    @foreach($question->matchPairs as $pair)
                                        <div class="matching-item right-item" 
                                             data-right="{{ $pair->right_text }}"
                                             onclick="selectMatchingItem(this, 'right', {{ $question->id }})">
                                            {{ $pair->right_text }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div id="matching-pairs-{{ $question->id }}" class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h5 class="font-semibold mb-2">Ваші пари:</h5>
                            <div id="pairs-display-{{ $question->id }}"></div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        {{-- Кнопка отправки --}}
        <div class="text-center mt-8">
            <button type="submit" 
                    class="px-8 py-4 bg-blue-600 text-white text-lg font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                Завершити тест
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function selectSingleChoice(element) {
    // Сброс всех радио в группе
    const container = element.closest('.question-card');
    container.querySelectorAll('.answer-option').forEach(opt => {
        opt.classList.remove('selected');
        opt.querySelector('.radio-indicator').style.backgroundColor = '';
    });
    
    // Выбор текущего
    element.classList.add('selected');
    element.querySelector('input').checked = true;
    element.querySelector('.radio-indicator').style.backgroundColor = '#3b82f6';
}

function toggleMultipleChoice(element) {
    const checkbox = element.querySelector('input');
    const indicator = element.querySelector('.checkbox-indicator');
    
    if (checkbox.checked) {
        checkbox.checked = false;
        element.classList.remove('selected');
        indicator.style.backgroundColor = '';
    } else {
        checkbox.checked = true;
        element.classList.add('selected');
        indicator.style.backgroundColor = '#3b82f6';
    }
}

let matchingSelections = {};

function selectMatchingItem(element, side, questionId) {
    const questionKey = `q${questionId}`;
    
    if (!matchingSelections[questionKey]) {
        matchingSelections[questionKey] = { left: null, right: null };
    }
    
    // Сброс предыдущего выбора для этой стороны
    const container = element.closest('.matching-container');
    container.querySelectorAll(`.${side}-item`).forEach(item => {
        item.classList.remove('selected');
    });
    
    // Выбор текущего элемента
    element.classList.add('selected');
    
    if (side === 'left') {
        matchingSelections[questionKey].left = element.dataset.left;
    } else {
        matchingSelections[questionKey].right = element.dataset.right;
    }
    
    // Если выбраны оба элемента, создаем пару
    if (matchingSelections[questionKey].left && matchingSelections[questionKey].right) {
        createMatchingPair(questionId);
    }
}

function createMatchingPair(questionId) {
    const questionKey = `q${questionId}`;
    const selection = matchingSelections[questionKey];
    
    const pairsDisplay = document.getElementById(`pairs-display-${questionId}`);
    const pairDiv = document.createElement('div');
    pairDiv.className = 'flex justify-between items-center p-2 bg-white rounded border mb-2';
    pairDiv.innerHTML = `
        <span>${selection.left} ↔ ${selection.right}</span>
        <button type="button" onclick="removePair(this, ${questionId})" class="text-red-500 hover:text-red-700">✕</button>
        <input type="hidden" name="answers[${questionId}][${selection.left}]" value="${selection.right}">
    `;
    
    pairsDisplay.appendChild(pairDiv);
    
    // Сброс выбора
    const container = document.getElementById(`matching-${questionId}`);
    container.querySelectorAll('.matching-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    matchingSelections[questionKey] = { left: null, right: null };
}

function removePair(button, questionId) {
    button.closest('div').remove();
}
</script>
@endpush
@endsection 