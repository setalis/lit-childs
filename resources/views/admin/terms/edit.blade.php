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
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Толкування терміна *
                    </label>
                    
                    <div id="definitions-container">
                        @foreach($term->definitions as $index => $definition)
                            <div class="definition-item border border-gray-300 rounded-md p-4 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Толкування {{ $index + 1 }} *
                                    </label>
                                    @if($index > 0)
                                        <button type="button" 
                                                onclick="removeDefinition(this)" 
                                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors text-sm">
                                            Видалити
                                        </button>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <textarea name="definitions[{{ $index }}][definition]" 
                                              rows="6"
                                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('definitions.' . $index . '.definition') border-red-500 @enderror"
                                              required>{{ old('definitions.' . $index . '.definition', $definition->definition) }}</textarea>
                                    @error('definitions.' . $index . '.definition')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Джерело інформації
                                    </label>
                                    <textarea name="definitions[{{ $index }}][source]" 
                                              rows="3"
                                              placeholder="Наприклад: Літературознавчий словник-довідник, 2-е вид., випр. і доп. / Р.Т. Громʼяк, Ю.І. Ковалів та ін. Київ : ВЦ 'Академія', 2006. 752 с."
                                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('definitions.' . $index . '.source') border-red-500 @enderror">{{ old('definitions.' . $index . '.source', $definition->source) }}</textarea>
                                    @error('definitions.' . $index . '.source')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <input type="hidden" name="definitions[{{ $index }}][id]" value="{{ $definition->id }}">
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" 
                            onclick="addDefinition()"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-sm">
                        + Додати ще одне толкування
                    </button>
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

<script>
let definitionCount = {{ $term->definitions->count() }};

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
        <div class="mb-4">
            <textarea name="definitions[${definitionCount}][definition]" 
                      rows="6"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Джерело інформації
            </label>
            <textarea name="definitions[${definitionCount}][source]" 
                      rows="3"
                      placeholder="Наприклад: Літературознавчий словник-довідник, 2-е вид., випр. і доп. / Р.Т. Громʼяк, Ю.І. Ковалів та ін. Київ : ВЦ 'Академія', 2006. 752 с."
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>
    `;
    
    container.appendChild(newItem);
    definitionCount++;
}

function removeDefinition(button) {
    button.closest('.definition-item').remove();
}
</script>
</x-layouts.app> 