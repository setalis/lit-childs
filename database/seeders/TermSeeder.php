<?php

namespace Database\Seeders;

use App\Models\Term;
use App\Models\TermDefinition;
use App\Models\TermImage;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем термин "Алегорія"
        $allegory = Term::create([
            'name' => 'Алегорія',
            'image_path' => 'images/terms/allegory.jpg',
        ]);

        // Создаем определение для "Алегорія"
        $allegoryDef = TermDefinition::create([
            'term_id' => $allegory->id,
            'definition' => 'Спосіб двопланового художнього зображення, що грунтується на приховуванні реальних осіб, явищ і предметів під конкретними художніми образами з відповідними асоціаціями, з характерними рисами приховуваного.',
            'source' => 'Літературознавчий словник-довідник',
            'sort_order' => 0,
        ]);

        // Создаем изображение для определения "Алегорія"
        TermImage::create([
            'term_definition_id' => $allegoryDef->id,
            'image_path' => 'images/terms/allegory_detail.jpg',
            'alt_text' => 'Детальна ілюстрація алегорії',
            'sort_order' => 0,
        ]);

        // Создаем термин "Балада"
        $ballad = Term::create([
            'name' => 'Балада',
            'image_path' => 'images/terms/ballad.jpg',
        ]);

        // Создаем определение для "Балада"
        $balladDef = TermDefinition::create([
            'term_id' => $ballad->id,
            'definition' => 'Жанр ліро-епічної поезії фантастичного, історико-героїчного або соціально-побутового характеру з драматичним сюжетом.',
            'source' => 'Літературознавчий словник-довідник',
            'sort_order' => 0,
        ]);

        // Создаем изображение для определения "Балада"
        TermImage::create([
            'term_definition_id' => $balladDef->id,
            'image_path' => 'images/terms/ballad_example.jpg',
            'alt_text' => 'Приклад балади',
            'sort_order' => 0,
        ]);

        // Создаем термин "Версифікація"
        $versification = Term::create([
            'name' => 'Версифікація',
        ]);

        // Создаем определение для "Версифікація"
        TermDefinition::create([
            'term_id' => $versification->id,
            'definition' => 'Система організації поетичного мовлення, в основі якої лежить закономірне ритмічне чергування певних мовних одиниць; віршування.',
            'source' => 'Літературознавчий словник-довідник',
            'sort_order' => 0,
        ]);

        // Создаем термин "Гіпербола"
        $hyperbole = Term::create([
            'name' => 'Гіпербола',
            'image_path' => 'images/terms/hyperbole.png',
        ]);

        // Создаем определение для "Гіпербола"
        $hyperboleDef = TermDefinition::create([
            'term_id' => $hyperbole->id,
            'definition' => 'Стилістична фігура явного і навмисного перебільшення для посилення виразності та підкреслення сказаної думки.',
            'source' => 'Літературознавчий словник-довідник',
            'sort_order' => 0,
        ]);

        // Создаем изображение для определения "Гіпербола"
        TermImage::create([
            'term_definition_id' => $hyperboleDef->id,
            'image_path' => 'images/terms/hyperbole_example.png',
            'alt_text' => 'Приклад гіперболи в тексті',
            'sort_order' => 0,
        ]);

        // Создаем термин "Автор" с несколькими определениями
        $author = Term::create([
            'name' => 'Автор',
        ]);

        // Первое определение для "Автор"
        $authorDef1 = TermDefinition::create([
            'term_id' => $author->id,
            'definition' => 'Це фізична особа, творчою працею якої створено твір.',
            'source' => 'Літературознавчий словник-довідник, 2-е вид., випр. і доп. / Р.Т. Громʼяк, Ю.І. Ковалів та ін. Київ : ВЦ "Академія", 2006. 752 с.',
            'sort_order' => 0,
        ]);

        // Второе определение для "Автор"
        $authorDef2 = TermDefinition::create([
            'term_id' => $author->id,
            'definition' => 'Той, хто створив твір; іноді автор присутній у творі як ліричний герой, іноді ніби грає роль автора, спілкується із читачем, часом створює образ наближеного до себе персонажа, свого другого "Я". Але навіть коли автор не з\'являється у творі, нічим не видає себе, ми відчуваємо його присутність – за мовою, за тим ставленням до героїв чи подій, яке виникає в читачів із волі автора.',
            'source' => 'Моклиця М. Вступ до літературознавства : посібник для студентів філологічних факультетів. Луцьк, 2011. 467 с.',
            'sort_order' => 1,
        ]);

        // Создаем изображение для второго определения "Автор"
        TermImage::create([
            'term_definition_id' => $authorDef2->id,
            'image_path' => 'images/terms/author_creative.jpg',
            'alt_text' => 'Автор за творчою роботою',
            'sort_order' => 0,
        ]);
    }
}
