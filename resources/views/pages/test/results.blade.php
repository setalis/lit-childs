@extends('layouts.app')

@section('title', 'Результати тесту: ' . $test->title . ' - Schoolbook')

@push('styles')
<style>
    .results-header-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: "#28569A";
        padding: 4rem 0;
    }
    .result-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .result-correct {
        border-left: 5px solid #10b981;
    }
    .result-incorrect {
        border-left: 5px solid #ef4444;
    }
    .score-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        color: white;
        margin: 0 auto;
    }
    .score-excellent { background: linear-gradient(135deg, #10b981, #059669); }
    .score-good { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .score-satisfactory { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .score-poor { background: linear-gradient(135deg, #ef4444, #dc2626); }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Заголовок результатов --}}
    <section class="results-header-bg rounded-lg shadow-lg mb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3">Результати тесту</h1>
            <h2 class="text-xl sm:text-2xl mb-4">{{ $test->title }}</h2>
            
            {{-- Оценка --}}
            <div class="mt-8">
                @if($score >= 90)
                    <div class="score-circle score-excellent">{{ $score }}%</div>
                    <p class="text-xl mt-4">Відмінно!</p>
                @elseif($score >= 70)
                    <div class="score-circle score-good">{{ $score }}%</div>
                    <p class="text-xl mt-4">Добре!</p>
                @elseif($score >= 50)
                    <div class="score-circle score-satisfactory">{{ $score }}%</div>
                    <p class="text-xl mt-4">Задовільно</p>
                @else
                    <div class="score-circle score-poor">{{ $score }}%</div>
                    <p class="text-xl mt-4">Потребує покращення</p>
                @endif
            </div>
            
            <div class="mt-6 space-y-2">
                <div class="bg-white bg-opacity-20 px-6 py-3 rounded-full inline-block">
                    <span class="text-lg">
                        Правильних відповідей: {{ $correctCount }} з {{ $totalQuestions }}
                    </span>
                </div>
                @if(isset($earnedPoints) && isset($totalPoints))
                    <div class="bg-white bg-opacity-20 px-6 py-3 rounded-full inline-block block">
                        <span class="text-lg">
                            Балів: {{ $earnedPoints }} з {{ $totalPoints }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Детальные результаты --}}
    <div class="mb-8">
        <h3 class="text-2xl font-semibold mb-6 text-gray-800">Детальні результати</h3>
        
        @foreach($results as $index => $result)
            <div class="result-card {{ $result['is_correct'] ? 'result-correct' : 'result-incorrect' }}">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">
                            Питання {{ $index + 1 }}
                            <span class="text-sm text-gray-500 ml-2">
                                ({{ ucfirst(str_replace('_', ' ', $result['question']->type)) }})
                            </span>
                            @if(isset($result['earned_points']) && isset($result['max_points']))
                                <span class="text-sm font-medium ml-2 px-2 py-1 rounded 
                                    {{ $result['earned_points'] == $result['max_points'] ? 'bg-green-100 text-green-800' : 
                                       ($result['earned_points'] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $result['earned_points'] }}/{{ $result['max_points'] }} балів
                                </span>
                            @endif
                        </h4>
                        <div class="flex items-center">
                            @if($result['is_correct'])
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-green-600 font-medium ml-2">Правильно</span>
                            @else
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-600 font-medium ml-2">Неправильно</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-gray-700 mb-3">{!! $result['question']->text !!}</p>
                    </div>

                    @if($result['question']->type === 'single_choice' || $result['question']->type === 'multiple_choice')
                        <div class="space-y-2">
                            @foreach($result['question']->answers as $answer)
                                @php
                                    $isUserChoice = false;
                                    if ($result['question']->type === 'single_choice') {
                                        $isUserChoice = $result['user_answer'] == $answer->id;
                                    } else {
                                        $isUserChoice = is_array($result['user_answer']) && in_array($answer->id, $result['user_answer']);
                                    }
                                @endphp
                                
                                <div class="p-3 rounded-lg border 
                                    @if($answer->is_correct) 
                                        bg-green-100 border-green-300
                                    @elseif($isUserChoice && !$answer->is_correct)
                                        bg-red-100 border-red-300
                                    @else
                                        bg-gray-50 border-gray-200
                                    @endif
                                ">
                                    <div class="flex items-center">
                                        @if($answer->is_correct)
                                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @elseif($isUserChoice)
                                            <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <div class="w-5 h-5 mr-2"></div>
                                        @endif
                                        
                                        <span class="
                                            @if($answer->is_correct) 
                                                text-green-800 font-medium
                                            @elseif($isUserChoice && !$answer->is_correct)
                                                text-red-800
                                            @else
                                                text-gray-700
                                            @endif
                                        ">
                                            {{ $answer->text }}
                                        </span>
                                        
                                        @if($isUserChoice)
                                            <span class="ml-auto text-sm 
                                                @if($answer->is_correct) 
                                                    text-green-600
                                                @else
                                                    text-red-600
                                                @endif
                                            ">
                                                (Ваш вибір)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @elseif($result['question']->type === 'fill_in_the_blank')
                        @php
                            $correctAnswers = $result['question']->answers->where('is_correct', true)->sortBy('blank_position');
                            $userAnswer = $result['user_answer'];
                            $isMultipleBlanks = is_array($userAnswer);
                        @endphp
                        <div class="space-y-3">
                            @if($isMultipleBlanks)
                                {{-- Множественные пропуски --}}
                                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <h5 class="font-semibold text-blue-800 mb-2">Текст с пропусками:</h5>
                                    <div class="text-gray-700">
                                        {!! preg_replace('/\[(\d+)\]/', '<span class="font-bold text-blue-600">[пропуск $1]</span>', $result['question']->text) !!}
                                    </div>
                                </div>
                                
                                @foreach($correctAnswers->groupBy('blank_position') as $blankPosition => $answersForPosition)
                                    @php
                                        $userText = $userAnswer[$blankPosition] ?? '';
                                        $correctAnswer = $answersForPosition->first();
                                        
                                        // Используем детальные результаты если доступны
                                        if (isset($result['blank_results'])) {
                                            $isBlankCorrect = $result['blank_results'][$blankPosition] ?? false;
                                        } else {
                                            // Fallback для старой логики
                                            $isBlankCorrect = false;
                                            foreach ($answersForPosition as $answer) {
                                                if (trim(strtolower($userText)) === trim(strtolower($answer->text))) {
                                                    $isBlankCorrect = true;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="flex items-start space-x-4 p-3 rounded-lg border 
                                        {{ $isBlankCorrect ? 'bg-green-100 border-green-300' : 'bg-red-100 border-red-300' }}">
                                        <div class="min-w-0 flex-1">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Пропуск {{ $blankPosition }}:
                                            </label>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <span class="text-xs text-gray-500">Ваша відповідь:</span>
                                                    <p class="text-lg {{ $isBlankCorrect ? 'text-green-800' : 'text-red-800' }}">
                                                        {{ $userText ?: '(не вказано)' }}
                                                    </p>
                                                </div>
                                                @if(!$isBlankCorrect)
                                                    <div>
                                                        <span class="text-xs text-gray-500">Правильні варіанти:</span>
                                                        <p class="text-lg text-green-800 font-medium">
                                                            {{ $answersForPosition->pluck('text')->join(', ') }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            @if($isBlankCorrect)
                                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- Один пропуск (старый формат) --}}
                                @php
                                    $correctAnswer = $correctAnswers->first();
                                @endphp
                                <div class="p-3 rounded-lg {{ $result['is_correct'] ? 'bg-green-100 border border-green-300' : 'bg-red-100 border border-red-300' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ваша відповідь:</label>
                                    <p class="text-lg {{ $result['is_correct'] ? 'text-green-800' : 'text-red-800' }}">
                                        {{ $userAnswer ?: '(не вказано)' }}
                                    </p>
                                </div>
                                @if(!$result['is_correct'] && $correctAnswer)
                                    <div class="p-3 rounded-lg bg-green-100 border border-green-300">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Правильна відповідь:</label>
                                        <p class="text-lg text-green-800 font-medium">{{ $correctAnswer->text }}</p>
                                    </div>
                                @endif
                            @endif
                        </div>

                    @elseif($result['question']->type === 'matching')
                        <div class="space-y-3">
                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <h5 class="font-semibold text-blue-800 mb-2">
                                    Результат за парами: {{ $result['earned_points'] ?? 0 }}/{{ $result['max_points'] ?? count($result['question']->matchPairs) }} балів
                                </h5>
                            </div>
                            
                            <div class="space-y-2">
                                <h5 class="font-medium text-gray-700 mb-3">Детальні результати по парах:</h5>
                                @foreach($result['question']->matchPairs as $pair)
                                    @php
                                        $userAnswer = is_array($result['user_answer']) ? ($result['user_answer'][$pair->left_text] ?? null) : null;
                                        $isCorrectPair = $userAnswer === $pair->right_text;
                                    @endphp
                                    <div class="flex items-center justify-between p-3 rounded-lg border 
                                        {{ $isCorrectPair ? 'bg-green-100 border-green-300' : 'bg-red-100 border-red-300' }}">
                                        <div class="flex-1">
                                            <span class="font-medium">{{ $pair->left_text }}</span>
                                            <span class="mx-2">↔</span>
                                            <span class="
                                                {{ $isCorrectPair ? 'text-green-800' : 'text-red-800' }}
                                            ">
                                                {{ $userAnswer ?? '(не обрано)' }}
                                            </span>
                                            @if(!$isCorrectPair && $userAnswer)
                                                <span class="text-sm text-gray-600 ml-3">
                                                    (правильно: <strong>{{ $pair->right_text }}</strong>)
                                                </span>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            @if($isCorrectPair)
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Кнопки действий --}}
    <div class="text-center space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
        <a href="{{ route('test.show', $test) }}" 
           class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Пройти тест ще раз
        </a>
        <button onclick="window.history.back()" 
                class="inline-block px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
            Повернутися назад
        </button>
    </div>
</div>
@endsection 