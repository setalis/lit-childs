<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestController extends Controller
{
    public function tinymce()
    {
        return view('test.tinymce');
    }

    public function show(Test $test): View
    {
        // Загружаем тест с вопросами, ответами и парами для сопоставления
        $test->load([
            'questions.answers',
            'questions.matchPairs'
        ]);

        // Перемешиваем правую колонку для вопросов типа "matching"
        $test->questions->each(function ($question) {
            if ($question->type === 'matching' && $question->matchPairs->isNotEmpty()) {
                // Создаем коллекцию правых элементов и перемешиваем её
                $rightItems = $question->matchPairs->pluck('right_text')->shuffle();
                
                // Присваиваем перемешанную коллекцию обратно как свойство
                $question->shuffled_right_items = $rightItems->values();
            }
        });

        return view('pages.test.show', compact('test'));
    }

    /**
     * Нормализует текст для сравнения ответов
     */
    private function normalizeText(string $text): string
    {
        // Убираем лишние пробелы и приводим к нижнему регистру
        $normalized = trim(mb_strtolower($text, 'UTF-8'));
        
        // Убираем множественные пробелы
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        
        // Убираем знаки препинания
        $normalized = preg_replace('/[^\w\s\d]/u', '', $normalized);
        
        return $normalized;
    }

    /**
     * Проверяет схожесть двух текстов (для учета окончаний)
     */
    private function isSimilarText(string $userAnswer, string $correctAnswer): bool
    {
        $userNormalized = $this->normalizeText($userAnswer);
        $correctNormalized = $this->normalizeText($correctAnswer);
        
        // Точное совпадение
        if ($userNormalized === $correctNormalized) {
            \Log::info("Exact match: '{$userAnswer}' === '{$correctAnswer}'");
            return true;
        }
        
        // Проверка схожести (для окончаний) - только для длинных слов
        $minLength = min(mb_strlen($userNormalized), mb_strlen($correctNormalized));
        
        if ($minLength >= 6) { // Только для слов длиной 6+ символов
            $similarity = 0;
            similar_text($userNormalized, $correctNormalized, $similarity);
            
            \Log::info("Similarity check: '{$userAnswer}' vs '{$correctAnswer}' = {$similarity}%");
            
            // Для длинных слов: схожесть 90%+ и разница не более 2 символов
            if ($similarity >= 90 && abs(mb_strlen($userNormalized) - mb_strlen($correctNormalized)) <= 2) {
                \Log::info("Similarity match (90%+): '{$userAnswer}' vs '{$correctAnswer}'");
                return true;
            }
        }
        
        // Проверка на основу слова (первые 80% символов совпадают) - только для длинных слов
        if ($minLength >= 5) {
            $baseLength = (int)($minLength * 0.8); // Увеличиваем до 80%
            $userBase = mb_substr($userNormalized, 0, $baseLength);
            $correctBase = mb_substr($correctNormalized, 0, $baseLength);
            
            \Log::info("Base check: '{$userBase}' vs '{$correctBase}' (first {$baseLength} chars, min length: {$minLength})");
            
            if ($userBase === $correctBase && $baseLength >= 4) { // Минимум 4 символа должны совпадать
                \Log::info("Base match: '{$userAnswer}' vs '{$correctAnswer}'");
                return true;
            }
        }
        
        \Log::info("No match: '{$userAnswer}' vs '{$correctAnswer}'");
        return false;
    }

    /**
     * Проверяет правильность ответа на fill_in_the_blank вопрос
     */
    private function checkFillInTheBlankAnswer($userAnswer, $correctAnswers): array
    {
        if (is_array($userAnswer)) {
            // Множественные пропуски
            $uniquePositions = $correctAnswers->pluck('blank_position')->unique();
            $totalBlanks = $uniquePositions->count();
            $correctBlankCount = 0;
            $blankResults = []; // Для детального отслеживания каждого пропуска
            
            foreach ($uniquePositions as $blankPosition) {
                $userText = $userAnswer[$blankPosition] ?? '';
                $correctAnswersForPosition = $correctAnswers->where('blank_position', $blankPosition);
                $isBlankCorrect = false;
                
                foreach ($correctAnswersForPosition as $correctAnswer) {
                    if ($this->isSimilarText($userText, $correctAnswer->text)) {
                        $isBlankCorrect = true;
                        break; // Найден правильный ответ для этой позиции
                    }
                }
                
                if ($isBlankCorrect) {
                    $correctBlankCount++;
                }
                
                $blankResults[$blankPosition] = $isBlankCorrect;
            }
            
            return [
                'is_correct' => $correctBlankCount === $totalBlanks && $totalBlanks > 0,
                'earned_points' => $correctBlankCount,
                'max_points' => $totalBlanks,
                'blank_results' => $blankResults // Добавляем детальные результаты
            ];
        } else {
            // Один пропуск (старый формат)
            foreach ($correctAnswers as $correctAnswer) {
                if ($this->isSimilarText($userAnswer, $correctAnswer->text)) {
                    return [
                        'is_correct' => true,
                        'earned_points' => 1,
                        'max_points' => 1
                    ];
                }
            }
            
            return [
                'is_correct' => false,
                'earned_points' => 0,
                'max_points' => 1
            ];
        }
    }

    public function submit(Test $test, Request $request)
    {
        $answers = $request->input('answers', []);
        $results = [];
        $totalPoints = 0; // Общее количество возможных баллов
        $earnedPoints = 0; // Заработанные баллы
        $totalQuestions = $test->questions->count();

        foreach ($test->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = false;
            $questionPoints = 1; // По умолчанию каждый вопрос стоит 1 балл
            $earnedQuestionPoints = 0;

            switch ($question->type) {
                case 'single_choice':
                    $correctAnswer = $question->answers->where('is_correct', true)->first();
                    $isCorrect = $correctAnswer && $userAnswer == $correctAnswer->id;
                    $earnedQuestionPoints = $isCorrect ? 1 : 0;
                    break;

                case 'multiple_choice':
                    $correctAnswers = $question->answers->where('is_correct', true)->pluck('id')->toArray();
                    $userAnswers = is_array($userAnswer) ? $userAnswer : [];
                    $isCorrect = count($correctAnswers) === count($userAnswers) && 
                                 count(array_diff($correctAnswers, $userAnswers)) === 0;
                    $earnedQuestionPoints = $isCorrect ? 1 : 0;
                    break;

                case 'fill_in_the_blank':
                    $fillInTheBlankResult = $this->checkFillInTheBlankAnswer($userAnswer, $question->answers);
                    $isCorrect = $fillInTheBlankResult['is_correct'];
                    $earnedQuestionPoints = $fillInTheBlankResult['earned_points'];
                    $questionPoints = $fillInTheBlankResult['max_points'];
                    
                    // Сохраняем детальные результаты для множественных пропусков
                    if (isset($fillInTheBlankResult['blank_results'])) {
                        $results[] = [
                            'question' => $question,
                            'user_answer' => $userAnswer,
                            'is_correct' => $isCorrect,
                            'max_points' => $questionPoints,
                            'earned_points' => $earnedQuestionPoints,
                            'blank_results' => $fillInTheBlankResult['blank_results']
                        ];
                        
                        $totalPoints += $questionPoints;
                        $earnedPoints += $earnedQuestionPoints;
                        continue 2; // Переходим к следующему вопросу
                    }
                    break;

                case 'matching':
                    // Для matching вопросов userAnswer должен быть массивом пар
                    $correctPairs = $question->matchPairs->pluck('right_text', 'left_text')->toArray();
                    $userPairs = is_array($userAnswer) ? $userAnswer : [];
                    
                    // Подсчитываем правильные пары (1 балл за каждую)
                    $correctPairCount = 0;
                    $totalPairs = count($correctPairs);
                    
                    foreach ($correctPairs as $left => $right) {
                        if (isset($userPairs[$left]) && $userPairs[$left] === $right) {
                            $correctPairCount++;
                        }
                    }
                    
                    $questionPoints = $totalPairs; // Максимум баллов = количество пар
                    $earnedQuestionPoints = $correctPairCount;
                    $isCorrect = $correctPairCount === $totalPairs; // Полностью правильно только если все пары верны
                    break;
            }

            $totalPoints += $questionPoints;
            $earnedPoints += $earnedQuestionPoints;

            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'max_points' => $questionPoints,
                'earned_points' => $earnedQuestionPoints
            ];
        }

        $score = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
        $correctCount = collect($results)->where('is_correct', true)->count();

        return view('pages.test.results', compact('test', 'results', 'correctCount', 'totalQuestions', 'score', 'totalPoints', 'earnedPoints'));
    }

    /**
     * Умная проверка ответа с учетом окончаний, регистра и вариантов написания
     */
    private function isAnswerCorrect($userAnswer, $correctAnswer)
    {
        // Приводим к нижнему регистру и убираем лишние пробелы
        $userText = trim(strtolower($userAnswer));
        $correctText = trim(strtolower($correctAnswer));
        
        // Точное совпадение
        if ($userText === $correctText) {
            return true;
        }
        
        // Проверка для украинских слов с возможными окончаниями
        if ($this->checkUkrainianWordVariants($userText, $correctText)) {
            return true;
        }
        
        // Проверка альтернативных написаний
        if ($this->checkAlternativeSpellings($userText, $correctText)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Проверка украинских слов с учетом возможных окончаний
     */
    private function checkUkrainianWordVariants($userText, $correctText)
    {
        // Общие украинские окончания для разных падежей
        $endings = [
            // Мужской род
            ['', 'а', 'у', 'ом', 'і', 'ів', 'ам', 'ами', 'ах'],
            // Женский род  
            ['а', 'и', 'і', 'у', 'ю', 'ою', 'ах', 'ам', 'ами'],
            // Средний род
            ['о', 'е', 'а', 'у', 'ом', 'і'],
            // Прилагательные
            ['ий', 'ій', 'ого', 'ому', 'им', 'ому', 'і', 'их', 'им', 'ими'],
        ];
        
        // Проверяем, является ли один текст основой другого с добавленным окончанием
        foreach ([$userText, $correctText] as $base) {
            foreach ([$correctText, $userText] as $variant) {
                if ($base !== $variant && str_starts_with($variant, $base)) {
                    $suffix = substr($variant, strlen($base));
                    foreach ($endings as $endingGroup) {
                        if (in_array($suffix, $endingGroup)) {
                            return true;
                        }
                    }
                }
            }
        }
        
        return false;
    }
    
    /**
     * Проверка альтернативных написаний
     */
    private function checkAlternativeSpellings($userText, $correctText)
    {
        // Словарь альтернативных написаний
        $alternatives = [
            'київ' => ['киев', 'кыив', 'kyiv', 'kiev'],
            'дніпро' => ['днепр', 'днипро', 'dnieper', 'dnipro'],
            'україна' => ['украина', 'ukraine'],
            'харків' => ['харьков', 'kharkiv'],
            'львів' => ['львов', 'lviv'],
            'одеса' => ['одесса', 'odesa', 'odessa'],
            // Числа словами
            '1991' => ['тисяча дев\'ятсот дев\'яносто один', 'одна тисяча дев\'ятсот дев\'яносто один'],
            '1' => ['один', 'одна', 'одне', 'первый', 'перший'],
            '2' => ['два', 'дві', 'другий', 'другой'],
            '3' => ['три', 'третий', 'третій'],
        ];
        
        // Проверяем прямые соответствия
        foreach ($alternatives as $main => $variants) {
            if (($userText === $main && in_array($correctText, $variants)) ||
                ($correctText === $main && in_array($userText, $variants)) ||
                (in_array($userText, $variants) && in_array($correctText, $variants))) {
                return true;
            }
        }
        
        return false;
    }
}
