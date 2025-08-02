@extends('layouts.app')

@section('title', 'Простий тест посилань')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Простий тест покращеної системи посилань</h1>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Тест різних відмінків (збереження оригінального тексту)</h2>
        
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Тест 1: Шевченко в різних відмінках</h3>
            <div class="bg-gray-100 p-4 rounded mb-2">
                <strong>Оригінальний текст:</strong><br>
                Творчість Шевченка справила вплив. Про Шевченка говорять. Шевченком захоплюються. До Шевченка звертаються.
            </div>
            <div class="bg-blue-50 p-4 rounded">
                <strong>Результат (оригінальний текст збережено):</strong><br>
                {!! process_figure_links('Творчість Шевченка справила вплив. Про Шевченка говорять. Шевченком захоплюються. До Шевченка звертаються.') !!}
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Тест 2: Регістр (збереження оригінального регістру)</h3>
            <div class="bg-gray-100 p-4 rounded mb-2">
                <strong>Оригінальний текст:</strong><br>
                ШЕВЧЕНКО був поетом. шевченко писав вірші. Шевченко створив твори.
            </div>
            <div class="bg-blue-50 p-4 rounded">
                <strong>Результат (оригінальний регістр збережено):</strong><br>
                {!! process_figure_links('ШЕВЧЕНКО був поетом. шевченко писав вірші. Шевченко створив твори.') !!}
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Тест 3: HTML контент (безпечна обробка)</h3>
            <div class="bg-gray-100 p-4 rounded mb-2">
                <strong>Оригінальний HTML:</strong><br>
                &lt;p&gt;Творчість &lt;strong&gt;Шевченка&lt;/strong&gt; справила вплив. Про &lt;em&gt;Шевченка&lt;/em&gt; говорять.&lt;/p&gt;
            </div>
            <div class="bg-blue-50 p-4 rounded">
                <strong>Результат (обробка тільки поза тегами):</strong><br>
                {!! process_figure_links('<p>Творчість <strong>Шевченка</strong> справила вплив. Про <em>Шевченка</em> говорять.</p>', true) !!}
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Тест 4: Терміни (література в різних відмінках)</h3>
            <div class="bg-gray-100 p-4 rounded mb-2">
                <strong>Оригінальний текст:</strong><br>
                Література є важливою. Про літературу говорять. Літературою захоплюються. До літератури звертаються.
            </div>
            <div class="bg-green-50 p-4 rounded">
                <strong>Результат (оригінальний текст збережено):</strong><br>
                {!! process_figure_links('Література є важливою. Про літературу говорять. Літературою захоплюються. До літератури звертаються.') !!}
            </div>
        </div>
    </div>

    <!-- Інформація про виправлення -->
    <div class="mt-8 bg-green-50 border border-green-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">✅ Виправлення системи</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Що було виправлено:</h3>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <li>✅ Збереження оригінального тексту в посиланнях</li>
                    <li>✅ Збереження оригінального регістру</li>
                    <li>✅ Не змінює текст на сторінці</li>
                    <li>✅ Розпізнає різні відмінки для пошуку</li>
                    <li>✅ Створює посилання з оригінальним текстом</li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-semibold mb-2">Приклади правильної роботи:</h3>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <li><strong>Шевченка</strong> → посилання з текстом "Шевченка"</li>
                    <li><strong>Шевченком</strong> → посилання з текстом "Шевченком"</li>
                    <li><strong>ШЕВЧЕНКО</strong> → посилання з текстом "ШЕВЧЕНКО"</li>
                    <li><strong>шевченко</strong> → посилання з текстом "шевченко"</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-8 text-center space-x-4">
        <a href="{{ route('test.flexible-links') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
            Повний тест системи
        </a>
        
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
            На головну
        </a>
    </div>
</div>

<style>
.figure-link {
    color: #2563eb;
    text-decoration: underline;
    text-decoration-style: dotted;
}

.figure-link:hover {
    color: #1d4ed8;
    text-decoration-style: solid;
}

.term-link {
    color: #059669;
    text-decoration: underline;
    text-decoration-style: dotted;
}

.term-link:hover {
    color: #047857;
    text-decoration-style: solid;
}
</style>
@endsection 