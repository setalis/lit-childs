<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestAnswer;
use App\Models\TestMatchPair;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // Тест з української літератури
        $test1 = Test::create([
            'title' => 'Тест з української літератури',
            'description' => 'Перевірка базових знань з української літератури',
            'order' => 1
        ]);

        // Питання одиночного вибору
        $question1 = TestQuestion::create([
            'test_id' => $test1->id,
            'text' => 'Хто написав поему "Кобзар"?',
            'type' => 'single_choice',
            'order' => 1
        ]);

        TestAnswer::create(['question_id' => $question1->id, 'text' => 'Тарас Шевченко', 'is_correct' => true, 'order' => 1]);
        TestAnswer::create(['question_id' => $question1->id, 'text' => 'Іван Франко', 'is_correct' => false, 'order' => 2]);
        TestAnswer::create(['question_id' => $question1->id, 'text' => 'Леся Українка', 'is_correct' => false, 'order' => 3]);
        TestAnswer::create(['question_id' => $question1->id, 'text' => 'Панас Мирний', 'is_correct' => false, 'order' => 4]);

        // Питання множинного вибору
        $question2 = TestQuestion::create([
            'test_id' => $test1->id,
            'text' => 'Які з перелічених творів належать Івану Франку?',
            'type' => 'multiple_choice',
            'order' => 2
        ]);

        TestAnswer::create(['question_id' => $question2->id, 'text' => 'Каменярі', 'is_correct' => true, 'order' => 1]);
        TestAnswer::create(['question_id' => $question2->id, 'text' => 'Мойсей', 'is_correct' => true, 'order' => 2]);
        TestAnswer::create(['question_id' => $question2->id, 'text' => 'Кавказ', 'is_correct' => false, 'order' => 3]);
        TestAnswer::create(['question_id' => $question2->id, 'text' => 'Лісова пісня', 'is_correct' => false, 'order' => 4]);

        // Питання дописування
        $question3 = TestQuestion::create([
            'test_id' => $test1->id,
            'text' => 'Доповніть цитату: "Борітеся - поборете, Вам Бог помагає! За вами правда, за вами..."',
            'type' => 'fill_in_the_blank',
            'order' => 3
        ]);

        TestAnswer::create(['question_id' => $question3->id, 'text' => 'слава', 'is_correct' => true, 'order' => 1]);

        // Питання на відповідність
        $question4 = TestQuestion::create([
            'test_id' => $test1->id,
            'text' => 'Встановіть відповідність між авторами та їх творами:',
            'type' => 'matching',
            'order' => 4
        ]);

        TestMatchPair::create(['question_id' => $question4->id, 'left_text' => 'Тарас Шевченко', 'right_text' => 'Заповіт', 'order' => 1]);
        TestMatchPair::create(['question_id' => $question4->id, 'left_text' => 'Леся Українка', 'right_text' => 'Лісова пісня', 'order' => 2]);
        TestMatchPair::create(['question_id' => $question4->id, 'left_text' => 'Іван Франко', 'right_text' => 'Каменярі', 'order' => 3]);

        // Другий тест з математики
        $test2 = Test::create([
            'title' => 'Базові знання з математики',
            'description' => 'Тест на перевірку математичних навичок',
            'order' => 2
        ]);

        // Питання одиночного вибору
        $question5 = TestQuestion::create([
            'test_id' => $test2->id,
            'text' => 'Чому дорівнює квадрат числа 7?',
            'type' => 'single_choice',
            'order' => 1
        ]);

        TestAnswer::create(['question_id' => $question5->id, 'text' => '49', 'is_correct' => true, 'order' => 1]);
        TestAnswer::create(['question_id' => $question5->id, 'text' => '14', 'is_correct' => false, 'order' => 2]);
        TestAnswer::create(['question_id' => $question5->id, 'text' => '21', 'is_correct' => false, 'order' => 3]);
        TestAnswer::create(['question_id' => $question5->id, 'text' => '35', 'is_correct' => false, 'order' => 4]);

        // Питання дописування
        $question6 = TestQuestion::create([
            'test_id' => $test2->id,
            'text' => 'Розв\'яжіть рівняння: 2x + 5 = 11. x = ?',
            'type' => 'fill_in_the_blank',
            'order' => 2
        ]);

        TestAnswer::create(['question_id' => $question6->id, 'text' => '3', 'is_correct' => true, 'order' => 1]);
    }
} 