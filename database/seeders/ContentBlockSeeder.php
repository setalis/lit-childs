<?php

namespace Database\Seeders;

use App\Models\TheoryBlock;
use App\Models\PracticeBlock;
use App\Models\HomeworkBlock;
use App\Models\ControlBlock;
use App\Models\BlockElement;
use App\Models\Subsection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Test;

class ContentBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Найдем первый подраздел (предполагаем, что он существует)
        $subsection1 = Subsection::find(1);

        if ($subsection1) {
            // 1. Создаем Теоретический блок для первого подраздела
            $theoryBlock = TheoryBlock::create([
                'subsection_id' => $subsection1->id,
            ]);

            // Добавляем элементы в теоретический блок
            $theoryBlock->elements()->create([
                'element_type' => 'text',
                'content' => '<p>З моменту винайдення людством письма почали виникати тексти, які згодом сформували літературу – один із сучасних видів мистецтва – мистецтво слова, яке оперує до образів як витоків художності у відтворенні навколишнього та внутрішнього світу людини. Образ нероздільно взаємопов’язаний зі словом, яке є універсальним інструментом створення, відображення та перетворення людського буття засобами літературної творчості.</p>
                <p>Література пов’язана з іншими видами мистецтв через простір (просторове мистецтво: живопис, скульптура, архітектура), час (часове мистецтво: музика, спів, танець, пантоміма), зображення (синтетичне мистецтво: театр, кіно). Відтак можна стверджувати, що література консолідує в собі інші види мистецтв і має перевагу над ними, адже всі твори мистецтва можуть бути описані засобами слова. У такий спосіб світова література та українська література зокрема відтворюють історичне буття людини, тонкощі людської душі, сприяють осмисленню дійсності та художнього світу.</p>
                <p>Література є одним з найдавніших видів мистецтва, витоки якого вчені вбачають у філософсько-естетичному пізнанні реальності. Так, усвідомлення специфіки художньої літератури як перевідтвореної форми пізнання дійсності розпочинається з питання гносеології: чи може література пізнавати світ? Це риторичне протиставлення намагалися розв’язати ще античні філософи: ідеаліст Платон та матеріаліст Арістотель. Перший відстоював думку, що література – це лише “тінь тіней”, неспроможна пізнавати навколишній світ, а другий розвивав теорію мімезису. </p>
                <p>Література здатна не лише відтворювати, але і сприяти пізнанню людиною  навколишнього світу в специфічній формі образів. У цьому зв’язку художні твори характеризують такі поняття, як об’єкт зображення, предмет зображення, предмет пізнання. Літературознавці чітко розмежовують ці поняття та стверджують, що в центрі художньої літератури повинна перебувати людина, а пріоритетом для художнього твору є будь-який об’єкт зображення реального світу. Саме цьому художню літературу і називають “підручником життя”, а художній твір є одним з основних джерел інтелектуально-духовного спадку людства.</p>
                <p>Художня література є об’єктом вивчення літературознавства і реалізується через художні твори, у яких майстерно втілено пізнану, осмислену і перетворену письменником реальність. З огляду на інформативність, емоційність, естетичність та образне наповнення творів їх диференціюють на художні та інформаційні тексти для дорослих і дітей. </p>
                ',
                'order' => 2,
            ]);

            $theoryBlock->elements()->create([
                'element_type' => 'keywords',
                'content' => json_encode(['письмо', 'текст', 'література', 'мистецтво', 'світова література', 'українська література', 'образ', 'літературна творчість', 'слово', 'живопис', 'скульптура', 'архітектура', 'музика', 'спів', 'танці', 'пантоміма', 'театр', 'кіно', 'художня література', 'гносеологія', 'мімезис', 'об\'єкт зображення', 'предмет зображення', 'предмет пізнання', 'художній твір', 'літературознавство', 'письменник', 'інформативність', 'емоційність', 'естетичність', 'художні та інформаційні тексти']),
                'order' => 1,
            ]);

            // 2. Создаем Практический блок (репродуктивный уровень)
            $practiceBlock1 = PracticeBlock::create([
                'subsection_id' => $subsection1->id,
                'level' => 'reproductive',
                'order' => 1,
            ]);
            $practiceBlock2 = PracticeBlock::create([
                'subsection_id' => $subsection1->id,
                'level' => 'constructive',
                'order' => 2,
            ]);
            $practiceBlock3 = PracticeBlock::create([
                'subsection_id' => $subsection1->id,
                'level' => 'creative',
                'order' => 3,
            ]);
            $practiceBlock1->elements()->create([
                'element_type' => 'text',
                'content' => '<p>Завдання 1: Дайте визначення поняттю «художня література».</p>',
                'order' => 1,
            ]);

            // 3. Создаем Задание для самостоятельной работы
            $homeworkBlock = HomeworkBlock::create([
                'subsection_id' => $subsection1->id,
            ]);
            $homeworkBlock->elements()->create([
                'element_type' => 'text',
                'content' => '<p>Прочитайте текст на сторінці X та підготуйте відповіді на питання.</p>',
                'order' => 1,
            ]);

            // 4. Создаем Блок контроля (питання для самоперевірки)
            $controlBlock1 = ControlBlock::create([
                'subsection_id' => $subsection1->id,
                'order' => 1,
            ]);
            $controlBlock1->elements()->create([
                'element_type' => 'text',
                'content' => '<p>1. Що таке художня література?</p><p>2. Які основні функції художньої літератури?</p>',
                'order' => 1,
            ]);
        }

        // Создаём дополнительный тест с множественными пропусками
        $multiBlankTest = Test::create([
            'title' => 'Тест з множинними пропусками',
            'description' => 'Тестування нової функціональності заповнення пропусків',
            'order' => 10,
        ]);

        $multiBlankQuestion = $multiBlankTest->questions()->create([
            'type' => 'fill_in_the_blank',
            'text' => 'Столиця України — це місто [1], а найбільша річка — [2]. У [3] році Україна стала незалежною.',
            'order' => 1,
        ]);

        // Пропуск 1: Разные варианты написания "Киев"
        $multiBlankQuestion->answers()->create([
            'text' => 'Київ',
            'is_correct' => true,
            'blank_position' => 1,
            'order' => 1,
        ]);
        $multiBlankQuestion->answers()->create([
            'text' => 'Киев',
            'is_correct' => true,
            'blank_position' => 1,
            'order' => 2,
        ]);
        $multiBlankQuestion->answers()->create([
            'text' => 'Киів',
            'is_correct' => true,
            'blank_position' => 1,
            'order' => 3,
        ]);

        // Пропуск 2: Разные варианты "Днепр"
        $multiBlankQuestion->answers()->create([
            'text' => 'Дніпро',
            'is_correct' => true,
            'blank_position' => 2,
            'order' => 1,
        ]);
        $multiBlankQuestion->answers()->create([
            'text' => 'Днепр',
            'is_correct' => true,
            'blank_position' => 2,
            'order' => 2,
        ]);
        $multiBlankQuestion->answers()->create([
            'text' => 'Днипро',
            'is_correct' => true,
            'blank_position' => 2,
            'order' => 3,
        ]);

        // Пропуск 3: Варианты года
        $multiBlankQuestion->answers()->create([
            'text' => '1991',
            'is_correct' => true,
            'blank_position' => 3,
            'order' => 1,
        ]);
        $multiBlankQuestion->answers()->create([
            'text' => 'тисяча дев\'ятсот дев\'яносто першому',
            'is_correct' => true,
            'blank_position' => 3,
            'order' => 2,
        ]);

        // Назначаем тест на контрольный блок для тестирования
        ControlBlock::create([
            'subsection_id' => $subsection1->id,
            'test_id' => $multiBlankTest->id,
            'order' => 2,
        ]);

        // Створюємо тест з парним відповідністю для перевірки перетасовування
        $matchingTest = Test::create([
            'title' => 'Тест на встановлення відповідності',
            'description' => 'Тест для перевірки правильного перемішування пар',
            'order' => 11,
        ]);

        $matchingQuestion = $matchingTest->questions()->create([
            'type' => 'matching',
            'text' => 'Встановіть відповідність між письменниками та їх творами:',
            'order' => 1,
        ]);

        // Додаємо пари для перевірки перемішування
        $matchingQuestion->matchPairs()->create([
            'left_text' => 'Тарас Шевченко',
            'right_text' => 'Кобзар',
            'order' => 1,
        ]);

        $matchingQuestion->matchPairs()->create([
            'left_text' => 'Іван Франко',
            'right_text' => 'Захар Беркут',
            'order' => 2,
        ]);

        $matchingQuestion->matchPairs()->create([
            'left_text' => 'Леся Українка',
            'right_text' => 'Лісова пісня',
            'order' => 3,
        ]);

        $matchingQuestion->matchPairs()->create([
            'left_text' => 'Михайло Коцюбинський',
            'right_text' => 'Тіні забутих предків',
            'order' => 4,
        ]);

        $matchingQuestion->matchPairs()->create([
            'left_text' => 'Панас Мирний',
            'right_text' => 'Хіба ревуть воли, як ясла повні?',
            'order' => 5,
        ]);

        // Друге питання matching для перевірки
        $matchingQuestion2 = $matchingTest->questions()->create([
            'type' => 'matching',
            'text' => 'Встановіть відповідність між країнами та їх столицями:',
            'order' => 2,
        ]);

        $matchingQuestion2->matchPairs()->create([
            'left_text' => 'Україна',
            'right_text' => 'Київ',
            'order' => 1,
        ]);

        $matchingQuestion2->matchPairs()->create([
            'left_text' => 'Франція',
            'right_text' => 'Париж',
            'order' => 2,
        ]);

        $matchingQuestion2->matchPairs()->create([
            'left_text' => 'Італія',
            'right_text' => 'Рим',
            'order' => 3,
        ]);

        $matchingQuestion2->matchPairs()->create([
            'left_text' => 'Німеччина',
            'right_text' => 'Берлін',
            'order' => 4,
        ]);

        // Назначаем тест с matching на контрольный блок
        ControlBlock::create([
            'subsection_id' => $subsection1->id,
            'test_id' => $matchingTest->id,
            'order' => 3,
        ]);

        // Тут можно добавить создание блоков для других подразделов и разделов
    }
}
