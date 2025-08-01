<div>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Управління Розділами</h1>
            <button wire:click="openCreateModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Додати Розділ</button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <input wire:model.debounce.300ms="search" type="text" placeholder="Пошук розділів..." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" wire:click="sortBy('order')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            Порядок @if($sortField === 'order') <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span> @endif
                        </th>
                        <th scope="col" wire:click="sortBy('title')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            Назва @if($sortField === 'title') <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span> @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Підрозділів
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Дії
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sections as $section)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $section->order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ Str::limit($section->title, 70) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $section->subsections_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button wire:click="openEditModal({{ $section->id }})" class="text-indigo-600 hover:text-indigo-900">Редагувати</button>
                                <button wire:click="openDeleteModal({{ $section->id }})" class="text-red-600 hover:text-red-900">Видалити</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Розділи не знайдено.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sections->hasPages())
            <div class="mt-6">
                {{ $sections->links() }}
            </div>
            @endif
</div>

{{-- TinyMCE Script --}}
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

<script>
// Инициализация при открытии модального окна
document.addEventListener('livewire:init', () => {
    Livewire.on('init-tinymce', () => {
        setTimeout(initSectionTinyMCE, 500);
    });
    
    Livewire.on('cleanup-tinymce', () => {
        if (typeof tinymce !== 'undefined' && tinymce.get('sectionDescription')) {
            tinymce.remove('sectionDescription');
        }
    });
});

function initSectionTinyMCE() {
    const textarea = document.getElementById('sectionDescription');
    
    if (textarea && typeof tinymce !== 'undefined') {
        console.log('Инициализируем TinyMCE для sectionDescription');
        
        // Удаляем существующий экземпляр, если он есть
        if (tinymce.get('sectionDescription')) {
            tinymce.remove('sectionDescription');
        }
        
        // Добавляем обработчик для формы, чтобы синхронизировать TinyMCE перед отправкой
        const form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const editor = tinymce.get('sectionDescription');
                if (editor) {
                    textarea.value = editor.getContent();
                }
            });
        }
        
                 // Добавляем синхронизацию перед каждым Livewire запросом
         document.addEventListener('livewire:morph', function() {
             const editor = tinymce.get('sectionDescription');
             if (editor) {
                 editor.save(); // Синхронизируем с textarea
             }
         });
         
         // Синхронизация перед любым Livewire запросом
         Livewire.hook('morph.updating', () => {
             const editor = tinymce.get('sectionDescription');
             if (editor) {
                 editor.save();
             }
         });
        
        // Дополнительная синхронизация при потере фокуса
        textarea.addEventListener('blur', function() {
            const editor = tinymce.get('sectionDescription');
            if (editor) {
                editor.save();
            }
        });
        
        tinymce.init({
            selector: '#sectionDescription',
            height: 300,
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
                    const textarea = document.getElementById('sectionDescription');
                    if (textarea) {
                        textarea.value = content;
                        // Триггерим событие input для Livewire
                        textarea.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                });
                
                // Дополнительная синхронизация при потере фокуса
                editor.on('blur', function() {
                    const content = editor.getContent();
                    const textarea = document.getElementById('sectionDescription');
                    if (textarea) {
                        textarea.value = content;
                        textarea.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                });
                
                editor.on('init', function() {
                    // Устанавливаем начальное содержимое при редактировании
                    const initialContent = document.getElementById('sectionDescription').value || '';
                    if (initialContent) {
                        editor.setContent(initialContent);
                    }
                });
            }
        });
    } else {
        console.log('TinyMCE не найден или textarea не существует для разделов');
    }
}
</script>

    @if($showFormModal)
        <div class="fixed z-20 inset-0 overflow-y-auto" aria-labelledby="modal-form-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form wire:submit.prevent="saveSection">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-form-title">
                                        {{ $editingSectionId ? 'Редагувати розділ' : 'Створити новий розділ' }}
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="sectionTitle" class="block text-sm font-medium text-gray-700">Назва розділу</label>
                                            <input wire:model.defer="sectionTitle" type="text" id="sectionTitle" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('sectionTitle') border-red-500 @enderror">
                                            @error('sectionTitle') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="sectionDescription" class="block text-sm font-medium text-gray-700">Опис (необов'язково)</label>
                                            <textarea id="sectionDescription" wire:model="sectionDescription" placeholder="Введіть опис розділу...">{!! $sectionDescription !!}</textarea>
                                            @error('sectionDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="sectionOrder" class="block text-sm font-medium text-gray-700">Порядок</label>
                                            <input wire:model.defer="sectionOrder" type="number" id="sectionOrder" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('sectionOrder') border-red-500 @enderror">
                                            @error('sectionOrder') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Зберегти
                            </button>
                            <button wire:click="closeFormModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Скасувати
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($showDeleteModal)
        <div class="fixed z-30 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Видалити розділ "{{ $deletingSectionTitle }}"?
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Ви впевнені, що хочете видалити цей розділ? Всі пов'язані підрозділи та їх контент також будуть видалені. Цю дію неможливо буде скасувати.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteSection" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Видалити
                        </button>
                        <button wire:click="closeDeleteModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Скасувати
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
