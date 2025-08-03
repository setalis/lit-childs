<x-layouts.app title="Додати персоналію">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.figures.index') }}" 
               class="text-blue-500 hover:text-blue-700 mr-4"
               wire:navigate>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold">Додати персоналію</h1>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <form action="{{ route('admin.figures.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                     <div>
                         <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                             Ім'я
                         </label>
                         <input type="text" 
                                name="first_name" 
                                id="first_name" 
                                value="{{ old('first_name') }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
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
                                value="{{ old('last_name') }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror"
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
                    <input type="file" 
                           name="image" 
                           id="image" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Поддерживаемые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</p>
                </div>

                <div class="mb-6">
                    <label for="biography" class="block text-sm font-medium text-gray-700 mb-2">
                        Біографія *
                    </label>
                    <textarea name="biography" 
                              id="biography" 
                              rows="10"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('biography') border-red-500 @enderror"
                              required>{{ old('biography') }}</textarea>
                    @error('biography')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                                         <a href="{{ route('admin.figures.index') }}" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
                        wire:navigate>
                         Скасувати
                     </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        Зберегти
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app> 