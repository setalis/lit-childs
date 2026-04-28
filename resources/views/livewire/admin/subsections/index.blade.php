<div>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Управління Підрозділами</h1>
            <button wire:click="openCreateModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Додати Підрозділ</button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Пошук підрозділів..." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <select wire:model.live="filterBySection" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Всі розділи</option>
                @foreach($allSections as $section)
                    <option value="{{ $section->id }}">{{ $section->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" wire:click="sortBy('order')" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer w-16">
                                № @if($sortField === 'order') <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span> @endif
                            </th>
                            <th scope="col" wire:click="sortBy('title')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer min-w-[200px]">
                                Назва @if($sortField === 'title') <span class="ml-1">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span> @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                                Розділ
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Контент
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                Дії
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($subsections as $subsection)
                            {{-- Рядок підрозділу --}}
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">
                                    {{ $subsection->section->order }}.{{ $subsection->order }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ Str::limit($subsection->title, 70) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Розділ {{ $subsection->section->order }}. {{ Str::limit($subsection->section->title, 30) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('admin.subsections.content', $subsection) }}" class="text-green-600 hover:text-green-900">Керувати</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-1">
                                    <button wire:click="openCreateSubSubsectionModal({{ $subsection->id }})"
                                        class="inline-flex items-center px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200"
                                        title="Додати під-підрозділ">
                                        + Під-підрозділ
                                    </button>
                                    <button wire:click="openEditModal({{ $subsection->id }})" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50" title="Редагувати">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $subsection->id }})" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Видалити">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>

                            {{-- Рядки під-підрозділів --}}
                            @foreach($subsection->subSubsections as $subSub)
                                <tr class="bg-purple-50 hover:bg-purple-100">
                                    <td class="px-2 py-3 whitespace-nowrap text-sm text-purple-700 text-center font-medium">
                                        {{ $subsection->section->order }}.{{ $subsection->order }}.{{ $subSub->order }}
                                    </td>
                                    <td class="py-3 text-sm text-purple-900">
                                        <div class="flex items-center pl-8">
                                            <svg class="w-4 h-4 text-purple-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            {{ Str::limit($subSub->title, 65) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-xs text-purple-500">
                                        Підрозділ {{ $subsection->section->order }}.{{ $subsection->order }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('admin.subsections.content', $subSub) }}" class="text-green-600 hover:text-green-900">Керувати</a>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium space-x-1">
                                        <button wire:click="openEditModal({{ $subSub->id }})" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50" title="Редагувати">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="openDeleteModal({{ $subSub->id }})" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Видалити">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Підрозділи не знайдено.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($subsections->hasPages())
            <div class="mt-6">
                {{ $subsections->links() }}
            </div>
        @endif
    </div>

    {{-- Модальне вікно форми --}}
    @if($showFormModal)
        <div class="fixed z-20 inset-0 overflow-y-auto" aria-labelledby="modal-form-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="saveSubsection">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-form-title">
                                        @if($editingSubsectionId)
                                            {{ $parentSubsectionId ? 'Редагувати під-підрозділ' : 'Редагувати підрозділ' }}
                                        @else
                                            {{ $parentSubsectionId ? 'Створити під-підрозділ' : 'Створити новий підрозділ' }}
                                        @endif
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="subsectionTitle" class="block text-sm font-medium text-gray-700">
                                                {{ $parentSubsectionId ? 'Назва під-підрозділу' : 'Назва підрозділу' }}
                                            </label>
                                            <input wire:model="subsectionTitle" type="text" id="subsectionTitle" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('subsectionTitle') border-red-500 @enderror">
                                            @error('subsectionTitle') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                        </div>

                                        @if($parentSubsectionId)
                                            {{-- Для під-підрозділу показуємо вибір батьківського підрозділу --}}
                                            <div>
                                                <label for="parentSubsectionId" class="block text-sm font-medium text-gray-700">Батьківський підрозділ</label>
                                                <select wire:model="parentSubsectionId" id="parentSubsectionId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="">Виберіть підрозділ</option>
                                                    @foreach($parentSubsections as $ps)
                                                        <option value="{{ $ps->id }}">
                                                            {{ $ps->section->order }}.{{ $ps->order }} — {{ Str::limit($ps->title, 50) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('parentSubsectionId') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                            </div>
                                        @else
                                            {{-- Для підрозділу показуємо вибір розділу --}}
                                            <div>
                                                <label for="selectedSectionId" class="block text-sm font-medium text-gray-700">Розділ</label>
                                                <select wire:model="selectedSectionId" id="selectedSectionId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('selectedSectionId') border-red-500 @enderror">
                                                    <option value="">Виберіть розділ</option>
                                                    @foreach($allSections as $section)
                                                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('selectedSectionId') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                            </div>
                                        @endif

                                        <div>
                                            <label for="subsectionOrder" class="block text-sm font-medium text-gray-700">Порядок</label>
                                            <input wire:model="subsectionOrder" type="number" id="subsectionOrder" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('subsectionOrder') border-red-500 @enderror">
                                            @error('subsectionOrder') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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

    {{-- Модальне вікно підтвердження видалення --}}
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
                                    Видалити "{{ $deletingSubsectionTitle }}"?
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Ви впевнені, що хочете видалити цей підрозділ? Всі пов'язані блоки та під-підрозділи також будуть видалені. Цю дію неможливо буде скасувати.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteSubsection" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
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
