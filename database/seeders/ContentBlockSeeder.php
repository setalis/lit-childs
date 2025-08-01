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
                'content' => '<h3>Художня література як вид мистецтва</h3><p>Це текст першого теоретичного блоку...</p>',
                'order' => 1,
            ]);

            $theoryBlock->elements()->create([
                'element_type' => 'image',
                'content' => json_encode(['path' => 'path/to/your/image.jpg', 'alt' => 'Опис зображення']),
                'order' => 2,
            ]);

            $theoryBlock->elements()->create([
                'element_type' => 'keywords',
                'content' => json_encode(['мистецтво', 'література', 'початкова школа']),
                'order' => 3,
            ]);

            // 2. Создаем Практический блок (репродуктивный уровень)
            $practiceBlock1 = PracticeBlock::create([
                'subsection_id' => $subsection1->id,
                'level' => 'reproductive',
                'order' => 1,
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
