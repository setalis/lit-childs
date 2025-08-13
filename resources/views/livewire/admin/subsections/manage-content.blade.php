<div class="p-6">
    <p class="text-sm text-gray-500">Підрозділ: <span class="font-medium">{{ $subsection->title }}</span> (Розділ: {{ $subsection->section->title }})</p>

    {{-- Теоретический блок --}}
    <div class="mt-8">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
            <h3 class="text-xl font-bold text-blue-800 mb-2">📚 Теоретичний блок</h3>
            <p class="text-sm text-blue-600 mb-4">Основний теоретичний матеріал підрозділу</p>
            
            @if($theoryBlock)
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-600">Елементів: {{ $theoryBlock->elements->count() }}</span>
                        <button wire:click="openCreateBlockElementModal('theory')" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Додати елемент</button>
                    </div>
                    @if($theoryBlock->elements->isNotEmpty())
                        <div class="space-y-2">
                            @foreach($theoryBlock->elements->sortBy('order') as $element)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border-l-4 border-blue-500">
                                    <div class="flex items-center space-x-3">
                                        @php
                                            $typeIcons = [
                                                'text' => '📝',
                                                'keywords' => '🔑',
                                                'list' => '📋',
                                                'image' => '🖼️'
                                            ];
                                            $typeNames = [
                                                'text' => 'Текст',
                                                'keywords' => 'Ключові слова',
                                                'list' => 'Список',
                                                'image' => 'Зображення'
                                            ];
                                            $icon = $typeIcons[$element->element_type] ?? '📄';
                                            $typeName = $typeNames[$element->element_type] ?? 'Елемент';
                                        @endphp
                                        <span class="text-lg">{{ $icon }}</span>
                                        <span class="text-base font-semibold text-blue-700">{{ $typeName }}</span>
                                        <span class="text-sm text-gray-500">(Порядок: {{ $element->order }})</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button wire:click="openEditBlockElementModal({{ $element->id }}, 'theory')" class="text-xs text-indigo-600 hover:text-indigo-900">Редагувати</button>
                                        <button wire:click="deleteBlockElement({{ $element->id }})" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Немає елементів</p>
                    @endif
                </div>
            @else
                <button wire:click="createTheoryBlock" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Створити теоретичний блок</button>
            @endif
        </div>
    </div>

    {{-- Практические блоки --}}
    <div class="mt-8">
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-xl font-bold text-green-800 mb-2">🔧 Практичні блоки</h3>
                    <p class="text-sm text-green-600">Завдання для практичного засвоєння матеріалу</p>
                </div>
                <button wire:click="openCreatePracticeBlockModal" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 transition-colors">Додати завдання</button>
            </div>
            
            @if($practiceBlocks->isNotEmpty())
                <div class="space-y-4">
                    @foreach($practiceBlocks->sortBy('order') as $block)
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-green-100">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-medium text-gray-900">Практичний блок #{{ $block->id }}</h4>
                                    @php
                                        $levelColors = [
                                            'easy' => 'bg-green-100 text-green-800',
                                            'medium' => 'bg-yellow-100 text-yellow-800',
                                            'hard' => 'bg-red-100 text-red-800'
                                        ];
                                        $levelColor = $levelColors[$block->level] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $levelColor }} mt-1">
                                        {{ $availablePracticeLevels[$block->level] ?? $block->level }}
                                    </span>
                                    <span class="text-sm text-gray-500 block mt-1">(Порядок: {{ $block->order }})</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button wire:click="openEditPracticeBlockModal({{ $block->id }})" class="text-xs text-indigo-600 hover:text-indigo-900">Редагувати</button>
                                    <button wire:click="deletePracticeBlock({{ $block->id }})" onclick="return confirm('Ви впевнені, що хочете видалити це практичне завдання та всі його елементи?') || event.stopImmediatePropagation()" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-600">Елементів: {{ $block->elements->count() }}</span>
                                <button wire:click="openCreateBlockElementModal('practice', {{ $block->id }})" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Додати елемент</button>
                            </div>
                            
                            @if($block->elements->isNotEmpty())
                                <div class="space-y-2">
                                    @foreach($block->elements->sortBy('order') as $element)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded border-l-4 border-green-500">
                                            <div class="flex items-center space-x-3">
                                                @php
                                                    $typeIcons = [
                                                        'text' => '📝',
                                                        'keywords' => '🔑',
                                                        'list' => '📋',
                                                        'image' => '🖼️'
                                                    ];
                                                    $typeNames = [
                                                        'text' => 'Текст',
                                                        'keywords' => 'Ключові слова',
                                                        'list' => 'Список',
                                                        'image' => 'Зображення'
                                                    ];
                                                    $icon = $typeIcons[$element->element_type] ?? '📄';
                                                    $typeName = $typeNames[$element->element_type] ?? 'Елемент';
                                                @endphp
                                                <span class="text-lg">{{ $icon }}</span>
                                                <span class="text-base font-semibold text-green-700">{{ $typeName }}</span>
                                                <span class="text-sm text-gray-500">(Порядок: {{ $element->order }})</span>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button wire:click="openEditBlockElementModal({{ $element->id }}, 'practice', {{ $block->id }})" class="text-xs text-indigo-600 hover:text-indigo-900">Редагувати</button>
                                                <button wire:click="deleteBlockElement({{ $element->id }})" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Немає елементів</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Немає практичних блоків</p>
            @endif
        </div>
    </div>

    {{-- Блок завдань для самостійної роботи --}}
    <div class="mt-8">
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg p-6 border border-yellow-200">
            <h3 class="text-xl font-bold text-yellow-800 mb-2">📝 Завдання для самостійної роботи</h3>
            <p class="text-sm text-yellow-600 mb-4">Додаткові завдання для закріплення матеріалу</p>
            
            @if($homeworkBlock)
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-600">Елементів: {{ $homeworkBlock->elements->count() }}</span>
                        <button wire:click="openCreateBlockElementModal('homework')" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Додати елемент</button>
                    </div>
                    @if($homeworkBlock->elements->isNotEmpty())
                        <div class="space-y-2">
                            @foreach($homeworkBlock->elements->sortBy('order') as $element)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border-l-4 border-yellow-500">
                                    <div class="flex items-center space-x-3">
                                        @php
                                            $typeIcons = [
                                                'text' => '📝',
                                                'keywords' => '🔑',
                                                'list' => '📋',
                                                'image' => '🖼️'
                                            ];
                                            $typeNames = [
                                                'text' => 'Текст',
                                                'keywords' => 'Ключові слова',
                                                'list' => 'Список',
                                                'image' => 'Зображення'
                                            ];
                                            $icon = $typeIcons[$element->element_type] ?? '📄';
                                            $typeName = $typeNames[$element->element_type] ?? 'Елемент';
                                        @endphp
                                        <span class="text-lg">{{ $icon }}</span>
                                        <span class="text-base font-semibold text-yellow-700">{{ $typeName }}</span>
                                        <span class="text-sm text-gray-500">(Порядок: {{ $element->order }})</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button wire:click="openEditBlockElementModal({{ $element->id }}, 'homework')" class="text-xs text-indigo-600 hover:text-indigo-900">Редагувати</button>
                                        <button wire:click="deleteBlockElement({{ $element->id }})" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Немає елементів</p>
                    @endif
                </div>
            @else
                <button wire:click="createHomeworkBlock" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Створити блок завдань для самостійної роботи</button>
            @endif
        </div>
    </div>

    {{-- Блоки контроля --}}
    <div class="mt-8">
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-xl font-bold text-purple-800 mb-2">✅ Блоки контролю</h3>
                    <p class="text-sm text-purple-600">Тестування та перевірка знань</p>
                </div>
                <div class="flex space-x-2">
                    <button wire:click="createTestControlBlock" class="px-3 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 transition-colors">Додати тестові завдання</button>
                    <button wire:click="createQuestionsControlBlock" class="px-3 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition-colors">Додати питання та завдання</button>
                </div>
            </div>
            
            @if($controlBlocks->isNotEmpty())
                <div class="space-y-4">
                    @foreach($controlBlocks as $block)
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-purple-100">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    @php
                                        $typeColors = [
                                            'test' => 'bg-green-100 text-green-800',
                                            'questions' => 'bg-blue-100 text-blue-800'
                                        ];
                                        $typeColor = $typeColors[$block->type] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeColor }}">
                                            {{ $block->type_display }}
                                        </span>
                                        <span class="text-sm text-gray-500">#{{ $block->id }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">(Порядок: {{ $block->order }})</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button wire:click="deleteControlBlock({{ $block->id }})" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                </div>
                            </div>
                            
                            @if($block->isTestType())
                                @if($block->test)
                                    <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500">
                                        <h4 class="text-md font-medium text-gray-700 mb-1">Призначений тест: {{ $block->test->title }}</h4>
                                        <span class="text-sm text-gray-600">Питань: {{ $block->test->questions->count() }}</span>
                                    </div>
                                @else
                                    <div class="mb-4 p-3 bg-yellow-50 border-l-4 border-yellow-500">
                                        <p class="text-sm text-yellow-800">Тест не призначено</p>
                                        <div class="mt-2">
                                            <select wire:model="selectedTestIds.{{ $block->id }}" class="text-sm border border-gray-300 rounded px-2 py-1">
                                                <option value="">Оберіть тест</option>
                                                @foreach($allTests as $test)
                                                    <option value="{{ $test->id }}">{{ $test->title }}</option>
                                                @endforeach
                                            </select>
                                            <button wire:click="saveSelectedTest({{ $block->id }})" class="ml-2 px-2 py-1 bg-blue-500 text-white rounded text-xs">Зберегти</button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="mb-4 p-3 bg-blue-50 border-l-4 border-blue-500">
                                    <p class="text-sm text-blue-800">Блок для питань та завдань</p>
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Елементи блоку:</h4>
                                <button wire:click="openCreateBlockElementModal('control', {{ $block->id }})" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Додати елемент</button>
                            </div>
                            
                            @if($block->elements->isNotEmpty())
                                <div class="space-y-2">
                                    @foreach($block->elements->sortBy('order') as $element)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded border-l-4 border-purple-500">
                                            <div class="flex items-center space-x-3">
                                                @php
                                                    $typeIcons = [
                                                        'text' => '📝',
                                                        'keywords' => '🔑',
                                                        'list' => '📋',
                                                        'image' => '🖼️'
                                                    ];
                                                    $typeNames = [
                                                        'text' => 'Текст',
                                                        'keywords' => 'Ключові слова',
                                                        'list' => 'Список',
                                                        'image' => 'Зображення'
                                                    ];
                                                    $icon = $typeIcons[$element->element_type] ?? '📄';
                                                    $typeName = $typeNames[$element->element_type] ?? 'Елемент';
                                                @endphp
                                                <span class="text-lg">{{ $icon }}</span>
                                                <span class="text-base font-semibold text-purple-700">{{ $typeName }}</span>
                                                <span class="text-sm text-gray-500">(Порядок: {{ $element->order }})</span>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button wire:click="openEditBlockElementModal({{ $element->id }}, 'control', {{ $block->id }})" class="text-xs text-indigo-600 hover:text-indigo-900">Редагувати</button>
                                                <button wire:click="deleteBlockElement({{ $element->id }})" class="text-xs text-red-600 hover:text-red-900">Видалити</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Немає елементів</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Немає блоків контролю</p>
            @endif
        </div>
    </div>

    {{-- Модальное окно для элементов блока --}}
    @if($showBlockElementModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <form wire:submit.prevent="saveBlockElement" id="blockElementForm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-element-form-title">
                            {{ $editingBlockElementId ? 'Редагувати елемент блоку' : 'Створити новий елемент блоку' }}
                        </h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="elementType" class="block text-sm font-medium text-gray-700">Тип елемента</label>
                            <select wire:model="elementType" id="elementType" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('elementType') border-red-500 @enderror">
                                <option value="">Оберіть тип</option>
                                @foreach($availableElementTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('elementType') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                                                 @if($elementType === 'text')
                             <div>
                                 <label for="elementContentText" class="block text-sm font-medium text-gray-700">Текст</label>
                                 <textarea wire:model.blur="elementContentText" id="elementContentText" rows="6" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('elementContentText') border-red-500 @enderror">{{ $elementContentText }}</textarea>
                                 @error('elementContentText') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                             </div>
                        @elseif($elementType === 'keywords')
                            <div>
                                <label for="elementContentKeywords" class="block text-sm font-medium text-gray-700">Ключові слова (через кому)</label>
                                <input wire:model="elementContentKeywords" type="text" id="elementContentKeywords" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('elementContentKeywords') border-red-500 @enderror">
                                @error('elementContentKeywords') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @elseif($elementType === 'list')
                            <div>
                                <label for="elementContentList" class="block text-sm font-medium text-gray-700">Список (кожен елемент з нового рядка)</label>
                                <textarea wire:model="elementContentList" id="elementContentList" rows="6" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('elementContentList') border-red-500 @enderror"></textarea>
                                @error('elementContentList') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @elseif($elementType === 'image')
                            <div>
                                <label for="elementContentImage" class="block text-sm font-medium text-gray-700">Зображення</label>
                                <input wire:model="elementContentImage" type="file" id="elementContentImage" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('elementContentImage') border-red-500 @enderror">
                                @error('elementContentImage') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <div>
                            <label for="elementOrder" class="block text-sm font-medium text-gray-700">Порядок</label>
                            <input wire:model.defer="elementOrder" type="number" id="elementOrder" min="0" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('elementOrder') border-red-500 @enderror">
                            @error('elementOrder') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="forceSyncAndSave()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Зберегти
                        </button>
                        <button wire:click="closeBlockElementModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Скасувати
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Модальное окно для практических блоков --}}
    @if($showPracticeBlockModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <form wire:submit.prevent="savePracticeBlock">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-practice-block-form-title">
                            {{ $editingPracticeBlockId ? 'Редагувати практичне завдання' : 'Створити нове практичне завдання' }}
                        </h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="practiceBlockLevel" class="block text-sm font-medium text-gray-700">Рівень</label>
                            <select wire:model="practiceBlockLevel" id="practiceBlockLevel" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('practiceBlockLevel') border-red-500 @enderror">
                                <option value="">Оберіть рівень</option>
                                @foreach($availablePracticeLevels as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('practiceBlockLevel') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="practiceBlockOrder" class="block text-sm font-medium text-gray-700">Порядок</label>
                            <input wire:model.defer="practiceBlockOrder" type="number" id="practiceBlockOrder" min="1" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('practiceBlockOrder') border-red-500 @enderror">
                            @error('practiceBlockOrder') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Зберегти
                        </button>
                        <button wire:click="closePracticeBlockModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Скасувати
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Модальное окно для создания блока контроля --}}
    @if($showCreateControlBlockModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Створити блок контролю</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Створити новий блок контролю для цього підрозділу?</p>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="createControlBlock" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Створити
                    </button>
                    <button wire:click="closeCreateControlBlockModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Скасувати
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- TinyMCE Script --}}
{{-- Используем TinyMCEManager для управления редактором --}}

<script>
// Инициализация TinyMCE при открытии модального окна
document.addEventListener('livewire:init', () => {
    Livewire.on('init-tinymce', () => {
        setTimeout(() => {
            if (typeof TinyMCEManager !== 'undefined') {
                const textarea = document.getElementById('elementContentText');
                if (textarea) {
                    textarea.classList.add('tinymce-editor');
                    // Добавляем специальную конфигурацию для загрузки изображений
                    textarea.setAttribute('data-tinymce', JSON.stringify({
                        height: 400,
                        plugins: [
                            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
                        ],
                        toolbar: 'undo redo | blocks | ' +
                        'bold italic backcolor | alignleft aligncenter ' +
                        'alignright alignjustify | bullist numlist outdent indent | ' +
                        'image | codesample code | removeformat | help',
                        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px } ol { list-style-type: decimal; margin-left: 20px; } ul { list-style-type: disc; margin-left: 20px; }',
                        // Настройки для загрузки изображений
                        images_upload_url: '{{ route("tinymce.upload-image") }}',
                        images_upload_handler: function (blobInfo, success, failure) {
                            var xhr, formData;
                            xhr = new XMLHttpRequest();
                            xhr.withCredentials = false;
                            xhr.open('POST', '{{ route("tinymce.upload-image") }}');
                            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                            xhr.onload = function() {
                                var json;
                                if (xhr.status != 200) {
                                    failure('HTTP Error: ' + xhr.status);
                                    return;
                                }
                                json = JSON.parse(xhr.responseText);
                                if (!json || typeof json.location != 'string') {
                                    failure('Invalid JSON: ' + xhr.responseText);
                                    return;
                                }
                                success(json.location);
                            };
                            formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());
                            xhr.send(formData);
                        },
                        setup: function(editor) {
                            // Синхронизируем при любых изменениях содержимого
                            editor.on('input change', function() {
                                const content = editor.getContent();
                                const textarea = document.getElementById('elementContentText');
                                if (textarea) {
                                    textarea.value = content;
                                    // Триггерим событие input для Livewire
                                    textarea.dispatchEvent(new Event('input', { bubbles: true }));
                                }
                            });
                            
                            // Дополнительная синхронизация при потере фокуса
                            editor.on('blur', function() {
                                const content = editor.getContent();
                                const textarea = document.getElementById('elementContentText');
                                if (textarea) {
                                    textarea.value = content;
                                    textarea.dispatchEvent(new Event('input', { bubbles: true }));
                                }
                            });
                            
                            editor.on('init', function() {
                                // Устанавливаем начальное содержимое при редактировании
                                const initialContent = document.getElementById('elementContentText').value || '';
                                if (initialContent) {
                                    editor.setContent(initialContent);
                                }
                                
                                // Добавляем обработчик отправки формы для принудительной синхронизации
                                const form = document.getElementById('blockElementForm');
                                if (form) {
                                    form.addEventListener('submit', function(e) {
                                        // Принудительно синхронизируем TinyMCE с textarea перед отправкой
                                        const currentEditor = tinymce.get('elementContentText');
                                        if (currentEditor) {
                                            const content = currentEditor.getContent();
                                            const textarea = document.getElementById('elementContentText');
                                            if (textarea) {
                                                textarea.value = content;
                                                // Обновляем модель Livewire
                                                textarea.dispatchEvent(new Event('input', { bubbles: true }));
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }));
                    
                    // Инициализируем редактор
                    if (typeof TinyMCEManager !== 'undefined') {
                        TinyMCEManager.getInstance().initAllEditors();
                    }
                }
            }
        }, 200);
    });
    
    Livewire.on('cleanup-tinymce', () => {
        if (typeof TinyMCEManager !== 'undefined') {
            TinyMCEManager.getInstance().cleanupAllEditors();
        }
    });
    
    // Добавляем дополнительную синхронизацию перед любыми Livewire запросами
    Livewire.hook('morph.updating', () => {
        const editor = tinymce.get('elementContentText');
        if (editor) {
            const content = editor.getContent();
            const textarea = document.getElementById('elementContentText');
            if (textarea) {
                textarea.value = content;
                // Обновляем модель Livewire
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }
    });
});

// Функция для принудительной синхронизации TinyMCE перед сохранением
function syncTinyMCEBeforeSave() {
    const editor = tinymce.get('elementContentText');
    if (editor) {
        const content = editor.getContent();
        const textarea = document.getElementById('elementContentText');
        if (textarea) {
            textarea.value = content;
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }
}

// Функция для принудительной синхронизации и сохранения
function forceSyncAndSave() {
    console.log('Принудительная синхронизация TinyMCE...');
    
    const editor = tinymce.get('elementContentText');
    if (editor) {
        const content = editor.getContent();
        const textarea = document.getElementById('elementContentText');
        
        console.log('Контент из TinyMCE:', content.substring(0, 100) + '...');
        
        if (textarea) {
            // Принудительно обновляем значение textarea
            textarea.value = content;
            
            // Обновляем Livewire модель
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
            
            // Дополнительно диспатчим blur для wire:model.blur
            textarea.dispatchEvent(new Event('blur', { bubbles: true }));
            
            console.log('Textarea обновлена, значение:', textarea.value.substring(0, 100) + '...');
            
            // Даем время на обновление Livewire модели, затем сохраняем
            setTimeout(() => {
                console.log('Вызываем saveBlockElement...');
                Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).call('saveBlockElement');
            }, 100);
        }
    } else {
        console.log('TinyMCE редактор не найден, сохраняем напрямую...');
        // Если TinyMCE не найден, сохраняем напрямую
        Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).call('saveBlockElement');
    }
}
</script> 