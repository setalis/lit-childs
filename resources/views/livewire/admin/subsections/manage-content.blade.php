<div class="p-6">
    <p class="text-sm text-gray-500">Підрозділ: <span class="font-medium">{{ $subsection->title }}</span> (Розділ: {{ $subsection->section->title }})</p>

    {{-- Теоретический блок --}}
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Теоретичний блок</h3>
        @if($theoryBlock)
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-600">Елементів: {{ $theoryBlock->elements->count() }}</span>
                    <button wire:click="openCreateBlockElementModal('theory')" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Додати елемент</button>
                </div>
                @if($theoryBlock->elements->isNotEmpty())
                    <div class="space-y-2">
                        @foreach($theoryBlock->elements->sortBy('order') as $element)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                <div class="flex items-center space-x-2">
                                    <span class="font-medium text-gray-700">{{ Str::ucfirst($element->element_type_display) }}</span>
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
            <button wire:click="createTheoryBlock" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Створити теоретичний блок</button>
        @endif
    </div>

    {{-- Практические блоки --}}
    <div class="mt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Практичні блоки</h3>
            <button wire:click="openCreatePracticeBlockModal" class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">Додати завдання</button>
        </div>
        @if($practiceBlocks->isNotEmpty())
            <div class="space-y-4">
                @foreach($practiceBlocks->sortBy('order') as $block)
                    <div class="bg-white shadow rounded-lg p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-medium text-gray-900">Практичний блок #{{ $block->id }}</h4>
                                <span class="font-medium text-gray-700">Рівень: {{ $availablePracticeLevels[$block->level] ?? $block->level }}</span>
                                <span class="text-sm text-gray-500">(Порядок: {{ $block->order }})</span>
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
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-gray-700">{{ Str::ucfirst($element->element_type_display) }}</span>
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

    {{-- Блок завдань для самостійної роботи --}}
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Завдання для самостійної роботи</h3>
        @if($homeworkBlock)
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-600">Елементів: {{ $homeworkBlock->elements->count() }}</span>
                    <button wire:click="openCreateBlockElementModal('homework')" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Додати елемент</button>
                </div>
                @if($homeworkBlock->elements->isNotEmpty())
                    <div class="space-y-2">
                        @foreach($homeworkBlock->elements->sortBy('order') as $element)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                <div class="flex items-center space-x-2">
                                    <span class="font-medium text-gray-700">{{ Str::ucfirst($element->element_type_display) }}</span>
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

    {{-- Блоки контроля --}}
    <div class="mt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Блоки контролю</h3>
            <div class="flex space-x-2">
                <button wire:click="createTestControlBlock" class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">Додати тестові завдання</button>
                <button wire:click="createQuestionsControlBlock" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Додати питання та завдання</button>
            </div>
        </div>
        @if($controlBlocks->isNotEmpty())
            <div class="space-y-4">
                @foreach($controlBlocks as $block)
                    <div class="bg-white shadow rounded-lg p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-700">{{ $block->type_display }} #{{ $block->id }}</h3>
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
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-gray-700">{{ Str::ucfirst($element->element_type_display) }}</span>
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

    {{-- Модальное окно для элементов блока --}}
    @if($showBlockElementModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <form wire:submit.prevent="saveBlockElement">
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
                                 <textarea wire:model="elementContentText" id="elementContentText" rows="6" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('elementContentText') border-red-500 @enderror">{{ $elementContentText }}</textarea>
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
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
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
{{-- TinyMCE загружается в основном layout --}}

<script>
// Инициализация TinyMCE при открытии модального окна
document.addEventListener('livewire:init', () => {
    Livewire.on('init-tinymce', () => {
        setTimeout(initTinyMCE, 200);
    });
    
    Livewire.on('cleanup-tinymce', () => {
        if (typeof tinymce !== 'undefined' && tinymce.get('elementContentText')) {
            tinymce.remove('elementContentText');
        }
    });
});

 function initTinyMCE() {
     const textarea = document.getElementById('elementContentText');
     
     if (textarea && typeof tinymce !== 'undefined') {
         console.log('Инициализируем TinyMCE для elementContentText');
         
         // Удаляем существующий экземпляр, если он есть
         if (tinymce.get('elementContentText')) {
             tinymce.remove('elementContentText');
         }
         
         // Добавляем обработчик для формы, чтобы синхронизировать TinyMCE перед отправкой
         const form = textarea.closest('form');
         if (form) {
             form.addEventListener('submit', function(e) {
                 const editor = tinymce.get('elementContentText');
                 if (editor) {
                     textarea.value = editor.getContent();
                 }
             });
         }
         
         // Добавляем синхронизацию перед каждым Livewire запросом
         document.addEventListener('livewire:morph', function() {
             const editor = tinymce.get('elementContentText');
             if (editor) {
                 editor.save(); // Синхронизируем с textarea
             }
         });
         
         // Синхронизация перед любым Livewire запросом
         Livewire.hook('morph.updating', () => {
             const editor = tinymce.get('elementContentText');
             if (editor) {
                 editor.save();
             }
         });
         
         // Дополнительная синхронизация при потере фокуса
         textarea.addEventListener('blur', function() {
             const editor = tinymce.get('elementContentText');
             if (editor) {
                 editor.save();
             }
         });
        
        tinymce.init({
            selector: '#elementContentText',
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
                   });
               }
        });
    }
}
</script> 