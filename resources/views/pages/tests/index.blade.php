@extends('layouts.app')
@section('title', 'Тестові завдання - Schoolbook')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Заголовок страницы --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-[#3A6EA5] mb-4">ТЕСТОВІ ЗАВДАННЯ</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Перевірте свої знання за допомогою інтерактивних тестів по кожному розділу та темі підручника
            </p>
        </div>

        {{-- Список тестов, сгруппированных по разделам и подразделам --}}
        @if($groupedTests->isEmpty())
            <div class="text-center py-12">
                <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-8 max-w-md mx-auto">
                    <div class="text-yellow-600 text-6xl mb-4">📝</div>
                    <h3 class="text-xl font-semibold text-yellow-800 mb-2">Тестів ще немає</h3>
                    <p class="text-yellow-700">На жаль, тестові завдання ще не додано до системи.</p>
                </div>
            </div>
        @else
            <div class="space-y-8">
                @foreach($groupedTests as $sectionTitle => $subsections)
                    {{-- Раздел --}}
                    <div class="bg-white rounded-2xl border border-[#94BDDD] shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-[#94BDDD] to-[#6a8eaa] px-6 py-4">
                            <h2 class="text-2xl font-bold text-white">{{ $sectionTitle }}</h2>
                        </div>
                        
                        <div class="p-6">
                            @foreach($subsections as $subsectionTitle => $tests)
                                {{-- Подраздел --}}
                                <div class="mb-8 last:mb-0">
                                    <h3 class="text-xl font-semibold text-[#3A6EA5] mb-4 pb-2 border-b border-gray-200">
                                        {{ $subsectionTitle }}
                                    </h3>
                                    
                                    {{-- Список тестов в подразделе --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($tests as $test)
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                                <div class="flex flex-col h-full">
                                                    {{-- Заголовок теста --}}
                                                    <h4 class="text-lg font-semibold text-gray-800 mb-2 flex-grow">
                                                        {{ $test->title }}
                                                    </h4>
                                                    
                                                    {{-- Описание теста --}}
                                                    @if($test->description)
                                                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                                            {!! Str::limit($test->description, 90) !!}
                                                        </p>
                                                    @endif
                                                    
                                                    {{-- Информация о тесте --}}

                                                    
                                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            {{ $test->questions->count() }} питань
                                                        </span>                                                    
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Тест
                                                        </span>
                                                    </div>
                                                    
                                                    {{-- Типы вопросов --}}
                                                    @php
                                                        $questionTypesDisplay = $test->getQuestionTypesDisplayAttribute();
                                                    @endphp
                                                    @if(!empty($questionTypesDisplay))
                                                        <div class="mb-4">
                                                            <span class="text-xs font-medium text-gray-600 mb-2 block">Типи питань:</span>
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach($questionTypesDisplay as $type)
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                        {{ $type }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    {{-- Кнопка перехода к тесту --}}
                                                    <a href="{{ route('test.show', $test) }}" 
                                                       class="bg-[#94BDDD] hover:bg-[#6a8eaa] text-white font-semibold py-2 px-4 rounded-lg text-center transition-colors duration-200 flex items-center justify-center">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Почати тест
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Дополнительная информация --}}
        <div class="mt-12 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-blue-800">Як працювати з тестами</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Оберіть тест зі списку вище</li>
                            <li>Уважно прочитайте кожне питання</li>
                            <li>Виберіть правильну відповідь або введіть текст</li>
                            <li>Після завершення ви отримаєте результат з поясненнями</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
