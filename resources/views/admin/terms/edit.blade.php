<x-layouts.app title="Редагувати термін">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.terms.index') }}" 
               class="text-blue-500 hover:text-blue-700 mr-4"
               wire:navigate>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold">Редагувати термін</h1>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.terms.update', $term) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Назва терміна *
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $term->name) }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Зображення
                    </label>
                    
                    @if($term->image_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $term->image_path) }}" 
                                 alt="{{ $term->name }}" 
                                 class="w-32 h-32 object-cover rounded-lg">
                            <p class="text-sm text-gray-500 mt-1">Поточне зображення</p>
                        </div>
                    @endif
                    
                    <input type="file" 
                           name="image" 
                           id="image" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Поддерживаемые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</p>
                    @if($term->image_path)
                        <p class="text-gray-500 text-sm">Залиште поле порожнім, якщо не хочете змінювати зображення</p>
                    @endif
                </div>

                <div class="mb-6">
                    <label for="definition" class="block text-sm font-medium text-gray-700 mb-2">
                        Визначення *
                    </label>
                    <textarea name="definition" 
                              id="definition" 
                              rows="10"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('definition') border-red-500 @enderror"
                              required>{{ old('definition', $term->definition) }}</textarea>
                    @error('definition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.terms.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
                       wire:navigate>
                        Скасувати
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        Оновити
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app> 