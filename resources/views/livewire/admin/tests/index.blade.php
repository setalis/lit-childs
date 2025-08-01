<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Тести</h1>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    <div class="mb-4 flex justify-end">
        <button wire:click="openCreateModal" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Додати тест</button>
    </div>
    <div class="bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Назва</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Опис</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Порядок</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tests as $test)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $test->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($test->description, 60) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $test->order }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <button wire:click="openEditModal({{ $test->id }})" class="text-indigo-600 hover:text-indigo-900 mr-2">Редагувати</button>
                            <button wire:click="delete({{ $test->id }})" onclick="return confirm('Ви впевнені, що хочете видалити цей тест?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-900">Видалити</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl overflow-y-auto max-h-[90vh]">
                <h3 class="text-lg font-semibold mb-4">@if($editingId) Редагування тесту @else Додавання тесту @endif</h3>
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Назва тесту</label>
                        <input type="text" wire:model.defer="title" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Опис</label>
                        <textarea wire:model.defer="description" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Порядок</label>
                        <input type="number" wire:model.defer="order" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Питання</span>
                            <div class="flex gap-2">
                                <button type="button" wire:click="collapseAllQuestions" class="px-2 py-1 bg-gray-200 rounded text-xs hover:bg-gray-300">Згорнути всі</button>
                                <button type="button" wire:click="expandAllQuestions" class="px-2 py-1 bg-gray-200 rounded text-xs hover:bg-gray-300">Розгорнути всі</button>
                                <button type="button" wire:click="addQuestion" class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">Додати питання</button>
                            </div>
                        </div>
                        @foreach($questions as $qIndex => $q)
                            <div class="border rounded p-3 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold">Питання #{{ $qIndex+1 }}</span>
                                    <div class="flex gap-2 items-center">
                                        <button type="button" wire:click="toggleCollapseQuestion({{ $qIndex }})" class="text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 flex items-center" title="Згорнути/Розгорнути">
                                            <svg class="w-4 h-4 transition-transform duration-200 @if(!($collapsedQuestions[$qIndex] ?? false)) rotate-90 @endif" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <button type="button" wire:click="removeQuestion({{ $qIndex }})" class="text-xs text-red-600 hover:text-red-900 p-1" title="Видалити">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @if(!($collapsedQuestions[$qIndex] ?? false))
                                <div class="mb-2">
                                    <label class="block text-xs font-bold mb-1">Тип питання</label>
                                    <select wire:model="questions.{{ $qIndex }}.type" class="border rounded px-2 py-1">
                                        @foreach($questionTypes as $type => $label)
                                            <option value="{{ $type }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-xs font-bold mb-1">Текст питання</label>
                                    <input type="text" wire:model="questions.{{ $qIndex }}.text" class="w-full border rounded px-2 py-1">
                                </div>
                                <div class="mb-2">
                                    <label class="block text-xs font-bold mb-1">Порядок</label>
                                    <input type="number" wire:model="questions.{{ $qIndex }}.order" class="w-24 border rounded px-2 py-1">
                                </div>
                                @if(in_array($q['type'], ['single_choice', 'multiple_choice']))
                                    <div class="mb-2">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs font-bold">Варіанти відповіді</span>
                                            <button type="button" wire:click="addAnswer({{ $qIndex }})" class="text-xs px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Додати варіант</button>
                                        </div>
                                        @foreach($q['answers'] as $aIndex => $a)
                                            <div class="flex items-center space-x-2 mb-1">
                                                <input type="text" wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.text" class="border rounded px-2 py-1 flex-1" placeholder="Варіант...">
                                                <label class="flex items-center text-xs">
                                                    <input type="checkbox" wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.is_correct" class="mr-1">
                                                    Правильний
                                                </label>
                                                <button type="button" wire:click="removeAnswer({{ $qIndex }}, {{ $aIndex }})" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($q['type'] === 'fill_in_the_blank')
                                    <div class="mb-2">
                                        <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-3">
                                            <h4 class="text-xs font-bold text-blue-800 mb-2">Інструкція</h4>
                                            <p class="text-xs text-blue-700 mb-2">
                                                Використовуйте <code>[1]</code>, <code>[2]</code>, <code>[3]</code> тощо для позначення місць пропусків у тексті питання.
                                            </p>
                                            <p class="text-xs text-blue-600">
                                                Приклад: "Столиця України — це місто [1], а найбільша річка — [2]."
                                            </p>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <button type="button" 
                                                    wire:click="detectBlanks({{ $qIndex }})" 
                                                    class="text-xs px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                                Знайти пропуски в тексті
                                            </button>
                                            @if(isset($q['detected_blanks']) && count($q['detected_blanks']) > 0)
                                                <span class="text-xs font-bold text-green-600 ml-2">
                                                    Знайдено пропусків: {{ count($q['detected_blanks']) }}
                                                    ({{ implode(', ', $q['detected_blanks']) }})
                                                </span>
                                            @endif
                                        </div>

                                                                                <label class="block text-xs font-bold mb-1">Правильні відповіді для кожного пропуску</label>
                                        <div class="text-xs text-blue-600 mb-2">
                                            💡 Можете додати кілька варіантів відповіді для кожного пропуску (різні написання, форми слова)
                                        </div>
                                        @if(isset($q['detected_blanks']) && count($q['detected_blanks']) > 0)
                                            @foreach($q['detected_blanks'] as $blankIndex => $blankNumber)
                                                <div class="border rounded p-3 mb-3 bg-gray-50">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-xs font-bold text-gray-700">Пропуск [{{ $blankNumber }}]</span>
                                                        <button type="button" 
                                                                wire:click="addBlankVariant({{ $qIndex }}, {{ $blankIndex }})"
                                                                class="text-xs px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                                            + Варіант
                                                        </button>
                                                    </div>
                                                    
                                                    @php $answerIndex = 0; @endphp
                                                    @if(isset($q['answers']))
                                                        @foreach($q['answers'] as $aIdx => $answer)
                                                            @if(isset($answer['blank_position']) && $answer['blank_position'] == $blankNumber)
                                                                <div class="flex items-center space-x-2 mb-2">
                                                                    <span class="text-xs text-gray-500">{{ $answerIndex + 1 }}.</span>
                                                                    <input type="text"
                                                                           wire:model="questions.{{ $qIndex }}.answers.{{ $aIdx }}.text"
                                                                           wire:key="answer-{{ $qIndex }}-{{ $aIdx }}"
                                                                           class="border rounded px-2 py-1 flex-1"
                                                                           placeholder="Варіант відповіді (наприклад: Київ, Киев, Киів)">
                                                                    @if($answerIndex > 0)
                                                                        <button type="button" 
                                                                                wire:click="removeBlankVariant({{ $qIndex }}, {{ $aIdx }})"
                                                                                class="text-xs text-red-600 hover:text-red-900">
                                                                            Видалити
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                @php $answerIndex++; @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @if($answerIndex == 0)
                                                        <input type="text"
                                                               wire:model="questions.{{ $qIndex }}.answers.{{ $blankIndex }}.text"
                                                               wire:key="blank-main-{{ $qIndex }}-{{ $blankNumber }}"
                                                               class="border rounded px-2 py-1 w-full"
                                                               placeholder="Основна відповідь для пропуску {{ $blankNumber }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-xs text-gray-500 italic">
                                                Додайте пропуски в текст питання, використовуючи [1], [2], тощо
                                            </div>
                                        @endif
                                    </div>
                                @elseif($q['type'] === 'matching')
                                    <div class="mb-2">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs font-bold">Пари для відповідності</span>
                                            <button type="button" wire:click="addMatchPair({{ $qIndex }})" class="text-xs px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Додати пару</button>
                                        </div>
                                        @foreach($q['match_pairs'] as $pIndex => $pair)
                                            <div class="flex items-center space-x-2 mb-1">
                                                <input type="text" wire:model="questions.{{ $qIndex }}.match_pairs.{{ $pIndex }}.left_text" class="border rounded px-2 py-1" placeholder="Ліва частина">
                                                <span class="text-xs">—</span>
                                                <input type="text" wire:model="questions.{{ $qIndex }}.match_pairs.{{ $pIndex }}.right_text" class="border rounded px-2 py-1" placeholder="Права частина">
                                                <button type="button" wire:click="removeMatchPair({{ $qIndex }}, {{ $pIndex }})" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Скасувати</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
