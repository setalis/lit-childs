<x-layouts.app title="Додати термін">

<style>
/* Скрываем только проблемные элементы TinyMCE, но не диалоговые окна */
.tox-silver-sink {
    position: fixed !important;
    z-index: 9999 !important;
}
.tox-tinymce-aux {
    position: fixed !important;
    z-index: 9999 !important;
}
</style>

<div class="container w-full mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.terms.index') }}" 
               class="text-blue-500 hover:text-blue-700 mr-4"
               wire:navigate>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold">Додати термін</h1>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.terms.store') }}" method="POST" enctype="multipart/form-data" id="termForm">
                @csrf

                {{-- Основная информация --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Основна інформація</h2>
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Назва терміна *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Зображення
                        </label>
                        <input type="file" 
                               name="image" 
                               id="image" 
                               accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Поддерживаемые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</p>
                    </div>
                </div>

                {{-- Определения термина --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Толкування терміна</h2>
                    
                    <div id="definitions-container">
                        <div class="definition-item border border-gray-300 rounded-md p-4 mb-4">
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Толкування 1 *
                                </label>
                                <textarea name="definitions[0][definition]" 
                                          id="definition_0"
                                          class="w-full border border-gray-300 rounded-md tinymce-editor"
                                          required>{{ old('definitions.0.definition') }}</textarea>
                                @error('definitions.0.definition')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Джерело інформації
                                </label>
                                <textarea name="definitions[0][source]" 
                                          id="source_0"
                                          placeholder="Наприклад: Літературознавчий словник-довідник, 2-е вид., випр. і доп. / Р.Т. Громʼяк, Ю.І. Ковалів та ін. Київ : ВЦ 'Академія', 2006. 752 с."
                                          class="w-full border border-gray-300 rounded-md"
                                          rows="3">{{ old('definitions.0.source') }}</textarea>
                                @error('definitions.0.source')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Для первого толкования не показываем поля дополнительных изображений --}}
                            <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Для першого толкування використовується основне зображення терміна вище
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" 
                            onclick="addDefinition()"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-sm">
                        + Додати ще одне толкування
                    </button>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.terms.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                       wire:navigate>
                        Скасувати
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Зберегти
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let definitionCount = 1;

function addDefinition() {
    const container = document.getElementById('definitions-container');
    const newItem = document.createElement('div');
    newItem.className = 'definition-item border border-gray-300 rounded-md p-4 mb-4';
    
    newItem.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Толкування ${definitionCount + 1} *
            </label>
            <button type="button" 
                    onclick="removeDefinition(this)" 
                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors text-sm">
                Видалити
            </button>
        </div>
        <div class="mb-6">
            <textarea name="definitions[${definitionCount}][definition]" 
                      id="definition_${definitionCount}"
                      class="w-full border border-gray-300 rounded-md tinymce-editor"
                      required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Джерело інформації
            </label>
            <textarea name="definitions[${definitionCount}][source]" 
                      id="source_${definitionCount}"
                      placeholder="Наприклад: Літературознавчий словник-довідник, 2-е вид., випр. і доп. / Р.Т. Громʼяк, Ю.І. Ковалів та ін. Київ : ВЦ 'Академія', 2006. 752 с."
                      class="w-full border border-gray-300 rounded-md tinymce-editor"></textarea>
        </div>

        {{-- Дополнительные изображения для определения (только для дополнительных толкований) --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Додаткові зображення
            </label>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <input type="file" 
                           name="definitions[${definitionCount}][images][]" 
                           accept="image/*"
                           class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" 
                           name="definitions[${definitionCount}][images_alt][]" 
                           placeholder="Alt текст"
                           class="w-32 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div id="additional-images-${definitionCount}" class="mt-2 space-y-2"></div>
            <button type="button" 
                    onclick="addImageField(${definitionCount})"
                    class="mt-2 px-3 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">
                + Додати зображення
            </button>
        </div>
    `;
    
    container.appendChild(newItem);
    definitionCount++;
    
    // Инициализируем TinyMCE для новых полей
    if (typeof TinyMCEManager !== 'undefined') {
        setTimeout(() => {
            TinyMCEManager.initAllEditors();
        }, 100);
    }
}

function removeDefinition(button) {
    button.closest('.definition-item').remove();
}

function addImageField(definitionIndex) {
    const container = document.getElementById(`additional-images-${definitionIndex}`);
    const newImageField = document.createElement('div');
    newImageField.className = 'flex items-center space-x-3';
    newImageField.innerHTML = `
        <input type="file" 
               name="definitions[${definitionIndex}][images][]" 
               accept="image/*"
               class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="text" 
               name="definitions[${definitionIndex}][images_alt][]" 
               placeholder="Alt текст"
               class="w-32 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    `;
    container.appendChild(newImageField);
}

document.addEventListener('DOMContentLoaded', function() {
    // Используем TinyMCEManager для инициализации
    if (typeof TinyMCEManager !== 'undefined') {
        // Инициализируем все textarea как редакторы
        const editors = ['definition_0', 'source_0'];
        
        editors.forEach(function(editorId) {
            const textarea = document.getElementById(editorId);
            if (textarea) {
                textarea.classList.add('tinymce-editor');
            }
        });
        
        // Инициализируем редакторы
        TinyMCEManager.initAllEditors();
        
        // Добавляем обработчик отправки формы для загрузки изображений
        const form = document.getElementById('termForm');
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                try {
                    // Загружаем все изображения перед отправкой формы
                    const uploadSuccess = await TinyMCEManager.getInstance().uploadAllImages();
                    
                    if (uploadSuccess) {
                        console.log('Изображения загружены, отправляем форму');
                        form.submit();
                    } else {
                        alert('Ошибка при загрузке изображений. Попробуйте еще раз.');
                    }
                } catch (error) {
                    console.error('Ошибка при загрузке изображений:', error);
                    alert('Ошибка при загрузке изображений: ' + error.message);
                }
            });
        }
    }
});
</script>

</x-layouts.app> 