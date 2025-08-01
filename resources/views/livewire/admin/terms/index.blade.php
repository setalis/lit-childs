<div>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Управління Словником</h1>
            <a href="{{ route('admin.terms.create') }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
               wire:navigate>
                Додати Термін
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <input wire:model.debounce.300ms="search" 
                   type="text" 
                   placeholder="Пошук термінів..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Зображення
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Назва
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Літера
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Створено
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Дії
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($terms as $term)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($term->image_path)
                                    <img src="{{ asset('storage/' . $term->image_path) }}" 
                                         alt="{{ $term->name }}" 
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $term->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($term->definition, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                                    {{ $term->first_letter }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $term->created_at->format('d.m.Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('terms.show', $term) }}" 
                                   class="text-blue-600 hover:text-blue-900" 
                                   target="_blank">
                                    Переглянути
                                </a>
                                <a href="{{ route('admin.terms.edit', $term) }}" 
                                   class="text-indigo-600 hover:text-indigo-900"
                                   wire:navigate>
                                    Редагувати
                                </a>
                                <button wire:click="confirmDelete({{ $term->id }})" 
                                        class="text-red-600 hover:text-red-900">
                                    Видалити
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Терміни не знайдено.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($terms->hasPages())
            <div class="mt-6">
                {{ $terms->links() }}
            </div>
        @endif
    </div>

    {{-- Modal для подтверждения удаления --}}
    @if($termToDelete)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Підтвердження видалення</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Ви впевнені, що хочете видалити термін "{{ $termToDelete->name }}"?
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="deleteTerm" 
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 mr-2">
                            Видалити
                        </button>
                        <button wire:click="$set('termToDelete', null)" 
                                class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400">
                            Скасувати
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
