<div class="block-element mb-3">
    @switch($element->element_type)
        @case('text')
            <div class="tinymce-content prose max-w-none">
                {!! $element->processed_content !!} {{-- Используем processed_content для автоматических ссылок --}}
            </div>
            @break

        @case('keywords')
            @php
                // Убираем json_decode, так как из админки приходит просто строка
                // Разделяем строку по запятой, удаляем пробелы вокруг каждого слова
                $keywords = !empty($element->content) && is_string($element->content) ? array_map('trim', explode(',', $element->content)) : [];
                // Удаляем пустые элементы, которые могут появиться из-за лишних запятых
                $keywords = array_filter($keywords);
            @endphp
            @if(!empty($keywords))
                <div class="mt-2">
                    <span class="font-semibold">Ключові слова:</span>
                    @foreach($keywords as $keyword)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $keyword }}</span>
                    @endforeach
                </div>
            @else
                 {{-- Можно добавить сообщение, если ключевые слова не указаны или контент пуст --}}
                 {{-- <p class="text-sm text-gray-500">Ключові слова не вказані.</p> --}}
            @endif
            @break

        @case('image')
            @if(!empty($element->content) && is_string($element->content))
                <figure class="my-4">
                    <img src="{{ asset('storage/' . $element->content) }}" 
                         alt="Зображення" {{-- Можете добавить поле alt в будущем, если нужно --}}
                         class="max-w-full h-auto rounded-lg shadow-md">
                    {{-- Можете добавить поле caption в будущем, если нужно --}}
                </figure>
            @else
                <p class="text-red-500">Помилка завантаження зображення: невірні дані (очікувався рядок з шляхом).</p>
            @endif
            @break

        @case('gallery')
            @php $galleryData = json_decode($element->content, true); @endphp
            @if(!empty($galleryData) && is_array($galleryData))
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 my-4">
                    @foreach($galleryData as $item)
                        @if(isset($item['path']))
                        <figure>
                            <img src="{{ asset('storage/' . $item['path']) }}" 
                                 alt="{{ $item['alt'] ?? 'Зображення галереї' }}" 
                                 class="w-full h-auto object-cover rounded-lg shadow-md aspect-square">
                            @if(isset($item['caption']))
                                <figcaption class="text-xs text-center text-gray-600 mt-1">{{ $item['caption'] }}</figcaption>
                            @endif
                        </figure>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-red-500">Помилка завантаження галереї: невірні дані.</p>
            @endif
            @break

        @case('button_group')
            @php $buttonsData = json_decode($element->content, true); @endphp
            @if(!empty($buttonsData) && is_array($buttonsData))
                <div class="my-4 space-x-2">
                    @foreach($buttonsData as $button)
                        <a href="{{ $button['url'] ?? '#' }}" 
                           class="{{ $button['class'] ?? 'px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600' }}" 
                           target="{{ $button['target'] ?? '_self' }}">
                            {{ $button['text'] ?? 'Кнопка' }}
                        </a>
                    @endforeach
                </div>
            @endif
            @break
            
        @default
            <p class="text-red-500">Невідомий тип елемента блока: {{ $element->element_type }}</p>
    @endswitch
</div> 