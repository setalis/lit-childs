<x-layouts.app title="Редагувати персоналію">

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

<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.figures.index') }}" 
               class="text-blue-500 hover:text-blue-700 mr-4"
               wire:navigate>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold">Редагувати персоналію</h1>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.figures.update', $figure) }}" method="POST" enctype="multipart/form-data" id="figureForm">
                @csrf
                @method('PUT')

                {{-- Основная информация --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Основна інформація</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Ім'я
                            </label>
                            <input type="text" 
                                   name="first_name" 
                                   id="first_name" 
                                   value="{{ old('first_name', $figure->first_name) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Прізвище *
                            </label>
                            <input type="text" 
                                   name="last_name" 
                                   id="last_name" 
                                   value="{{ old('last_name', $figure->last_name) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Фотографія
                        </label>
                        @if($figure->image_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $figure->image_path) }}" 
                                     alt="{{ $figure->display_name }}" 
                                     class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
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

                {{-- Основные поля с редактором --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Основні поля</h2>
                    
                    <div class="mb-6">
                        <label for="biography" class="block text-sm font-medium text-gray-700 mb-2">
                            Основна біографія *
                        </label>
                        <textarea name="biography" id="biography" class="w-full border border-gray-300 rounded-md" required>{{ old('biography', $figure->biography) }}</textarea>
                        @error('biography')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Короткий опис для карточки персоналии</p>
                    </div>

                    <div class="mb-6">
                        <label for="sources" class="block text-sm font-medium text-gray-700 mb-2">
                            Основні джерела *
                        </label>
                        <textarea name="sources" id="sources" class="w-full border border-gray-300 rounded-md" required>{{ old('sources', $figure->sources) }}</textarea>
                        @error('sources')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Основні джерела інформації</p>
                    </div>
                </div>

                {{-- Дополнительные поля с редактором --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Додаткові поля</h2>
                    
                    <div class="mb-6">
                        <label for="biography_2" class="block text-sm font-medium text-gray-700 mb-2">
                            Додаткова біографія
                        </label>
                        <textarea name="biography_2" id="biography_2" class="w-full border border-gray-300 rounded-md">{{ old('biography_2', $figure->biography_2) }}</textarea>
                        @error('biography_2')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Додаткова інформація про персоналію</p>
                    </div>

                    <div class="mb-6">
                        <label for="sources_2" class="block text-sm font-medium text-gray-700 mb-2">
                            Додаткові джерела
                        </label>
                        <textarea name="sources_2" id="sources_2" class="w-full border border-gray-300 rounded-md">{{ old('sources_2', $figure->sources_2) }}</textarea>
                        @error('sources_2')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Додаткові джерела інформації</p>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.figures.index') }}" 
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
document.addEventListener('DOMContentLoaded', function() {
    // Используем TinyMCEManager для инициализации
    if (typeof TinyMCEManager !== 'undefined') {
        // Инициализируем все textarea как редакторы
        const editors = ['biography', 'sources', 'biography_2', 'sources_2'];
        
        editors.forEach(function(editorId) {
            const textarea = document.getElementById(editorId);
            if (textarea) {
                textarea.classList.add('tinymce-editor');
            }
        });
        
        // Инициализируем редакторы
        TinyMCEManager.initAllEditors();
    }
});
</script>

</x-layouts.app> 