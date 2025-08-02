@extends('layouts.app')

@section('title', 'Тест гнучких посилань')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Тест гнучкої системи автоматичних посилань</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Тест персоналій -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Тест персоналій (різні відмінки)</h2>
            
            <div class="prose max-w-none mb-4">
                <h3>Оригінальний текст:</h3>
                <p class="bg-gray-100 p-3 rounded">
                    Творчість Тараса Шевченка справила величезний вплив на українську культуру. 
                    Про твори Шевченка говорять у всьому світі. 
                    Шевченком захоплюються читачі різних країн. 
                    До Шевченка звертаються дослідники. 
                    Про Шевченка пишуть критики.
                </p>
            </div>

            <div class="prose max-w-none">
                <h3>Оброблений текст:</h3>
                <div class="bg-blue-50 p-3 rounded">
                    {!! process_figure_links('Творчість Тараса Шевченка справила величезний вплив на українську культуру. Про твори Шевченка говорять у всьому світі. Шевченком захоплюються читачі різних країн. До Шевченка звертаються дослідники. Про Шевченка пишуть критики.') !!}
                </div>
            </div>
        </div>

        <!-- Тест термінів -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Тест термінів (різні відмінки)</h2>
            
            <div class="prose max-w-none mb-4">
                <h3>Оригінальний текст:</h3>
                <p class="bg-gray-100 p-3 rounded">
                    Література є важливою частиною культури. 
                    Про літературу говорять у школах. 
                    Літературою захоплюються молоді люди. 
                    До літератури звертаються студенти. 
                    Про літературу пишуть вчені.
                </p>
            </div>

            <div class="prose max-w-none">
                <h3>Оброблений текст:</h3>
                <div class="bg-green-50 p-3 rounded">
                    {!! process_figure_links('Література є важливою частиною культури. Про літературу говорять у школах. Літературою захоплюються молоді люди. До літератури звертаються студенти. Про літературу пишуть вчені.') !!}
                </div>
            </div>
        </div>

        <!-- Тест регістру -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Тест регістру</h2>
            
            <div class="prose max-w-none mb-4">
                <h3>Оригінальний текст:</h3>
                <p class="bg-gray-100 p-3 rounded">
                    ШЕВЧЕНКО був великим поетом. 
                    шевченко писав вірші. 
                    Шевченко створив багато творів.
                </p>
            </div>

            <div class="prose max-w-none">
                <h3>Оброблений текст:</h3>
                <div class="bg-yellow-50 p-3 rounded">
                    {!! process_figure_links('ШЕВЧЕНКО був великим поетом. шевченко писав вірші. Шевченко створив багато творів.') !!}
                </div>
            </div>
        </div>

        <!-- Тест HTML контенту -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Тест HTML контенту</h2>
            
            <div class="prose max-w-none mb-4">
                <h3>Оригінальний HTML:</h3>
                <div class="bg-gray-100 p-3 rounded text-sm">
                    &lt;p&gt;Творчість &lt;strong&gt;Тараса Шевченка&lt;/strong&gt; справила вплив. Про &lt;em&gt;Шевченка&lt;/em&gt; говорять у світі.&lt;/p&gt;
                </div>
            </div>

            <div class="prose max-w-none">
                <h3>Оброблений HTML:</h3>
                <div class="bg-purple-50 p-3 rounded">
                    {!! process_figure_links('<p>Творчість <strong>Тараса Шевченка</strong> справила вплив. Про <em>Шевченка</em> говорять у світі.</p>', true) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Інформація про систему -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Інформація про покращену систему</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Що було покращено:</h3>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <li>✅ Підтримка різних відмінків української мови</li>
                    <li>✅ Ігнорування регістру (великі/малі літери)</li>
                    <li>✅ Автоматичне визначення базової форми слова</li>
                    <li>✅ Генерація варіантів з різними закінченнями</li>
                    <li>✅ Безпечна обробка HTML контенту</li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-semibold mb-2">Приклади роботи:</h3>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <li><strong>Шевченко</strong> → Шевченка, Шевченком, Шевченка, Шевченку</li>
                    <li><strong>література</strong> → літератури, літературою, літератури, літературі</li>
                    <li><strong>ШЕВЧЕНКО</strong> → шевченко, Шевченко, ШЕВЧЕНКА</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Кнопки навігації -->
    <div class="mt-8 text-center space-x-4">
        <a href="{{ route('figures.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
            Переглянути персоналії
        </a>
        
        <a href="{{ route('terms.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition-colors">
            Переглянути терміни
        </a>
        
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
            На головну
        </a>
    </div>
</div>

<style>
.figure-link {
    position: relative;
    text-decoration: underline;
    text-decoration-style: dotted;
}

.figure-link:hover {
    text-decoration-style: solid;
}

.term-link {
    position: relative;
    text-decoration: underline;
    text-decoration-style: dotted;
}

.term-link:hover {
    text-decoration-style: solid;
}
</style>
@endsection 