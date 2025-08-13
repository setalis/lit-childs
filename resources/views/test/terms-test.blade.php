@extends('layouts.app')

@section('title', 'Тест термінів')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Тест функціональності термінів</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Створення терміна</h2>
            <form action="{{ route('admin.terms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Назва терміна *</label>
                    <input type="text" name="name" required 
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Толкування 1 *</label>
                    <textarea name="definitions[0][definition]" rows="4" required
                              class="w-full border border-gray-300 rounded-md px-3 py-2"
                              placeholder="Автор – це фізична особа, творчою працею якої створено твір."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Джерело 1</label>
                    <textarea name="definitions[0][source]" rows="2"
                              class="w-full border border-gray-300 rounded-md px-3 py-2"
                              placeholder="Літературознавчий словник-довідник, 2-е вид., випр. і доп. / Р.Т. Громʼяк, Ю.І. Ковалів та ін. Київ : ВЦ 'Академія', 2006. 752 с."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Толкування 2</label>
                    <textarea name="definitions[1][definition]" rows="4"
                              class="w-full border border-gray-300 rounded-md px-3 py-2"
                              placeholder="Автор – той, хто створив твір; іноді автор присутній у творі як ліричний герой..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Джерело 2</label>
                    <textarea name="definitions[1][source]" rows="2"
                              class="w-full border border-gray-300 rounded-md px-3 py-2"
                              placeholder="Моклиця М. Вступ до літературознавства : посібник для студентів філологічних факультетів. Луцьк, 2011. 467 с."></textarea>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    Створити термін
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Поточні терміни</h2>
            @if(isset($terms) && $terms->count() > 0)
                <div class="space-y-4">
                    @foreach($terms as $term)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-semibold text-lg">{{ $term->name }}</h3>
                            @if($term->definitions->count() > 0)
                                <div class="text-sm text-gray-600 mt-2">
                                    <strong>Толкувань:</strong> {{ $term->definitions->count() }}
                                </div>
                                @foreach($term->definitions as $index => $definition)
                                    <div class="mt-2 p-3 bg-gray-50 rounded">
                                        <div class="text-sm"><strong>{{ $index + 1 }}.</strong> {!! Str::limit($definition->definition, 100) !!}</div>
                                        @if($definition->source)
                                            <div class="text-xs text-gray-500 mt-1">
                                                <strong>Джерело:</strong> {!! Str::limit($definition->source, 80) !!}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-sm text-gray-400">Толкування відсутні</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Терміни не знайдено</p>
            @endif
        </div>
    </div>
</div>
@endsection



