<?php

use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestAnswer;

test('multiple choice questions give points for each correct answer', function () {
    // Создаем тест с вопросом множественного выбора
    $test = Test::factory()->create(['title' => 'Test Multiple Choice Scoring']);
    
    // Создаем вопрос с несколькими правильными ответами
    $question = TestQuestion::factory()->create([
        'test_id' => $test->id,
        'type' => 'multiple_choice',
        'text' => 'Какие из перечисленных являются столицами?'
    ]);
    
    // Создаем ответы: 3 правильных, 2 неправильных
    $correctAnswer1 = TestAnswer::factory()->create([
        'question_id' => $question->id,
        'text' => 'Киев',
        'is_correct' => true
    ]);
    
    $correctAnswer2 = TestAnswer::factory()->create([
        'question_id' => $question->id,
        'text' => 'Лондон',
        'is_correct' => true
    ]);
    
    $correctAnswer3 = TestAnswer::factory()->create([
        'question_id' => $question->id,
        'text' => 'Париж',
        'is_correct' => true
    ]);
    
    $wrongAnswer1 = TestAnswer::factory()->create([
        'question_id' => $question->id,
        'text' => 'Москва',
        'is_correct' => false
    ]);
    
    $wrongAnswer2 = TestAnswer::factory()->create([
        'question_id' => $question->id,
        'text' => 'Берлин',
        'is_correct' => false
    ]);
    
    // Тест 1: Все правильные ответы выбраны
    $response = $this->post(route('tests.submit', $test), [
        'answers' => [
            $question->id => [
                $correctAnswer1->id,
                $correctAnswer2->id,
                $correctAnswer3->id
            ]
        ]
    ]);
    
    $response->assertStatus(200);
    $response->assertViewHas('earnedPoints', 3); // 3 балла за 3 правильных ответа
    $response->assertViewHas('totalPoints', 3); // Максимум 3 балла
    
    // Тест 2: Только 2 из 3 правильных ответов выбраны
    $response = $this->post(route('tests.submit', $test), [
        'answers' => [
            $question->id => [
                $correctAnswer1->id,
                $correctAnswer2->id
            ]
        ]
    ]);
    
    $response->assertStatus(200);
    $response->assertViewHas('earnedPoints', 2); // 2 балла за 2 правильных ответа
    $response->assertViewHas('totalPoints', 3); // Максимум 3 балла
    
    // Тест 3: Выбраны правильные ответы + неправильный
    $response = $this->post(route('tests.submit', $test), [
        'answers' => [
            $question->id => [
                $correctAnswer1->id,
                $correctAnswer2->id,
                $wrongAnswer1->id // Неправильный ответ
            ]
        ]
    ]);
    
    $response->assertStatus(200);
    $response->assertViewHas('earnedPoints', 2); // Только 2 балла за правильные ответы
    $response->assertViewHas('totalPoints', 3); // Максимум 3 балла
});

test('single choice questions still give 1 point for correct answer', function () {
    // Создаем тест с вопросом одиночного выбора
    $test = Test::factory()->create(['title' => 'Test Single Choice Scoring']);
    
    $question = TestQuestion::factory()->create([
        'test_id' => $test->id,
        'type' => 'single_choice',
        'text' => 'Какая столица Украины?'
    ]);
    
    $correctAnswer = TestAnswer::factory()->create([
        'question_id' => $question->id,
        'text' => 'Киев',
        'is_correct' => true
    ]);
    
    $wrongAnswer = TestAnswer::factory()->create([
        'question_id' => $question->id,
        'text' => 'Харьков',
        'is_correct' => false
    ]);
    
    // Правильный ответ
    $response = $this->post(route('tests.submit', $test), [
        'answers' => [
            $question->id => $correctAnswer->id
        ]
    ]);
    
    $response->assertStatus(200);
    $response->assertViewHas('earnedPoints', 1); // 1 балл за правильный ответ
    $response->assertViewHas('totalPoints', 1); // Максимум 1 балл
});
