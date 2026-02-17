<?php

namespace App\Livewire\Admin\Tests;

use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $showModal = false;

    /** @var array<string, \Illuminate\Http\UploadedFile> Файли зображень для пар (ключ: temp_id пари) */
    public $matchPairImages = [];

    public $editingId = null;

    public $title = '';

    public $description = '';

    public $order = 0;

    public $questions = [];

    public $questionTypes = [
        'single_choice' => 'Один правильний варіант',
        'multiple_choice' => 'Кілька правильних варіантів',
        'fill_in_the_blank' => 'Дописати відповідь',
        'matching' => 'Встановити відповідність',
    ];

    public $collapsedQuestions = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'order' => 'nullable|integer',
    ];

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('init-test-tinymce');
    }

    public function openEditModal($id)
    {
        $test = Test::with('questions.answers', 'questions.matchPairs')->findOrFail($id);
        $this->editingId = $id;
        $this->title = $test->title;
        $this->description = $test->description;
        $this->order = $test->order;

        $this->showModal = true;
        $this->dispatch('init-test-tinymce');

        $this->questions = [];
        foreach ($test->questions as $q) {
            $item = [
                'id' => $q->id,
                'type' => $q->type,
                'text' => $q->text,
                'order' => $q->order,
                'answers' => [],
                'match_pairs' => [],
            ];
            if (in_array($q->type, ['single_choice', 'multiple_choice'])) {
                foreach ($q->answers as $a) {
                    $item['answers'][] = [
                        'id' => $a->id,
                        'text' => $a->text,
                        'is_correct' => $a->is_correct,
                    ];
                }
            } elseif ($q->type === 'fill_in_the_blank') {
                // Загружаем ответы для fill_in_the_blank, отсортированные по blank_position
                $sortedAnswers = $q->answers->sortBy('blank_position');
                $detectedBlanks = [];
                foreach ($sortedAnswers as $a) {
                    $item['answers'][] = [
                        'id' => $a->id,
                        'text' => $a->text,
                        'is_correct' => $a->is_correct,
                        'blank_position' => $a->blank_position,
                    ];
                    $detectedBlanks[] = $a->blank_position;
                }
                $item['detected_blanks'] = $detectedBlanks;
            } elseif ($q->type === 'matching') {
                foreach ($q->matchPairs as $pair) {
                    $item['match_pairs'][] = [
                        'id' => $pair->id,
                        'temp_id' => 'pair_'.$pair->id,
                        'left_text' => $pair->left_text,
                        'right_text' => $pair->right_text,
                        'right_image_path' => $pair->right_image_path,
                        'right_type' => $pair->right_image_path ? 'image' : 'text',
                        'is_distractor' => $pair->is_distractor ?? false,
                    ];
                }
            }
            $this->questions[] = $item;
        }
        $this->collapsedQuestions = array_fill(0, count($this->questions), false);
        $this->showModal = true;
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'id' => null,
            'type' => 'single_choice',
            'text' => '',
            'order' => count($this->questions),
            'answers' => [],
            'match_pairs' => [],
        ];
        $this->collapsedQuestions[] = false;
    }

    public function removeQuestion($index)
    {
        array_splice($this->questions, $index, 1);
        array_splice($this->collapsedQuestions, $index, 1);
    }

    public function addAnswer($qIndex)
    {
        $this->questions[$qIndex]['answers'][] = [
            'id' => null,
            'text' => '',
            'is_correct' => false,
        ];
    }

    public function removeAnswer($qIndex, $aIndex)
    {
        array_splice($this->questions[$qIndex]['answers'], $aIndex, 1);
    }

    public function addMatchPair($qIndex)
    {
        $this->questions[$qIndex]['match_pairs'][] = [
            'id' => null,
            'temp_id' => 'pair_'.Str::random(8),
            'left_text' => '',
            'right_text' => '',
            'right_image_path' => null,
            'right_type' => 'text',
            'is_distractor' => false,
        ];
    }

    public function removeMatchPair($qIndex, $pIndex)
    {
        $pair = $this->questions[$qIndex]['match_pairs'][$pIndex] ?? null;
        if ($pair && isset($pair['temp_id'])) {
            unset($this->matchPairImages[$pair['temp_id']]);
        }
        array_splice($this->questions[$qIndex]['match_pairs'], $pIndex, 1);
    }

    public function removeMatchPairImage($qIndex, $pIndex): void
    {
        if (isset($this->questions[$qIndex]['match_pairs'][$pIndex])) {
            $pair = &$this->questions[$qIndex]['match_pairs'][$pIndex];
            if (isset($pair['temp_id'])) {
                unset($this->matchPairImages[$pair['temp_id']]);
            }
            $pair['right_image_path'] = null;
            $pair['right_type'] = 'text';
        }
    }

    public function toggleCollapseQuestion($index)
    {
        $this->collapsedQuestions[$index] = ! $this->collapsedQuestions[$index];
    }

    public function collapseAllQuestions()
    {
        $this->collapsedQuestions = array_fill(0, count($this->questions), true);
    }

    public function expandAllQuestions()
    {
        $this->collapsedQuestions = array_fill(0, count($this->questions), false);
    }

    public function detectBlanks($qIndex)
    {
        if (! isset($this->questions[$qIndex])) {
            return;
        }

        $questionText = $this->questions[$qIndex]['text'] ?? '';

        // Находим все пропуски в формате [1], [2], [3] и т.д.
        preg_match_all('/\[(\d+)\]/', $questionText, $matches);

        if (! empty($matches[1])) {
            // Получаем уникальные номера пропусков и сортируем их
            $blankNumbers = array_unique($matches[1]);
            sort($blankNumbers, SORT_NUMERIC);

            $this->questions[$qIndex]['detected_blanks'] = $blankNumbers;

            // Инициализируем массив ответов если его нет
            if (! isset($this->questions[$qIndex]['answers'])) {
                $this->questions[$qIndex]['answers'] = [];
            }

            // Создаем поля для ответов если их не хватает
            foreach ($blankNumbers as $index => $blankNumber) {
                // Проверяем, есть ли уже ответ для этой позиции
                $hasAnswerForPosition = false;
                foreach ($this->questions[$qIndex]['answers'] as $answer) {
                    if (isset($answer['blank_position']) && $answer['blank_position'] == $blankNumber) {
                        $hasAnswerForPosition = true;
                        break;
                    }
                }

                if (! $hasAnswerForPosition) {
                    $this->questions[$qIndex]['answers'][] = [
                        'text' => '',
                        'is_correct' => true,
                        'blank_position' => $blankNumber,
                    ];
                }
            }
        } else {
            $this->questions[$qIndex]['detected_blanks'] = [];
        }
    }

    public function addBlankVariant($qIndex, $blankIndex)
    {
        if (! isset($this->questions[$qIndex]['detected_blanks'][$blankIndex])) {
            return;
        }

        $blankNumber = $this->questions[$qIndex]['detected_blanks'][$blankIndex];

        $this->questions[$qIndex]['answers'][] = [
            'text' => '',
            'is_correct' => true,
            'blank_position' => $blankNumber,
        ];
    }

    public function removeBlankVariant($qIndex, $answerIndex)
    {
        if (isset($this->questions[$qIndex]['answers'][$answerIndex])) {
            unset($this->questions[$qIndex]['answers'][$answerIndex]);
            // Пересобираем массив для корректных индексов
            $this->questions[$qIndex]['answers'] = array_values($this->questions[$qIndex]['answers']);
        }
    }

    public function closeModal()
    {
        $this->dispatch('cleanup-test-tinymce');
        $this->showModal = false;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate();

        // Отладочная информация
        logger('Сохранение теста:', [
            'description' => $this->description,
            'description_length' => strlen($this->description),
            'contains_html' => strpos($this->description, '<') !== false,
        ]);
        if ($this->editingId) {
            $test = Test::findOrFail($this->editingId);
            $test->update([
                'title' => $this->title,
                'description' => $this->description,
                'order' => $this->order,
            ]);
            // Удаляем старые вопросы и их варианты
            foreach ($test->questions as $oldQ) {
                $oldQ->answers()->delete();
                $oldQ->matchPairs()->delete();
                $oldQ->delete();
            }
        } else {
            $test = Test::create([
                'title' => $this->title,
                'description' => $this->description,
                'order' => $this->order,
            ]);
        }
        // Сохраняем вопросы и варианты
        foreach ($this->questions as $qIndex => $q) {
            $question = new TestQuestion([
                'type' => $q['type'],
                'text' => $q['text'],
                'order' => $q['order'] ?? $qIndex,
            ]);
            $test->questions()->save($question);
            if (in_array($q['type'], ['single_choice', 'multiple_choice'])) {
                foreach ($q['answers'] as $a) {
                    $question->answers()->create([
                        'text' => $a['text'],
                        'is_correct' => ! empty($a['is_correct']),
                    ]);
                }
            } elseif ($q['type'] === 'fill_in_the_blank') {
                // Обрабатываем множественные пропуски
                if (isset($q['detected_blanks']) && ! empty($q['detected_blanks'])) {
                    foreach ($q['detected_blanks'] as $blankIndex => $blankNumber) {
                        if (! empty($q['answers'][$blankIndex]['text'])) {
                            $question->answers()->create([
                                'text' => $q['answers'][$blankIndex]['text'],
                                'is_correct' => true,
                                'blank_position' => $blankNumber,
                                'order' => $blankIndex,
                            ]);
                        }
                    }
                } else {
                    // Fallback для старого формата (один пропуск)
                    if (! empty($q['answers'][0]['text'])) {
                        $question->answers()->create([
                            'text' => $q['answers'][0]['text'],
                            'is_correct' => true,
                            'blank_position' => 1,
                        ]);
                    }
                }
            } elseif ($q['type'] === 'matching') {
                foreach ($q['match_pairs'] as $pair) {
                    $leftText = ! empty($pair['left_text']) ? $pair['left_text'] : null;
                    $rightText = null;
                    $rightImagePath = null;

                    if (($pair['right_type'] ?? 'text') === 'image') {
                        $tempId = $pair['temp_id'] ?? null;
                        $uploadedFile = $tempId ? ($this->matchPairImages[$tempId] ?? null) : null;
                        if ($uploadedFile) {
                            $rightImagePath = $uploadedFile->store('test_match_pairs', 'public');
                        } elseif (! empty($pair['right_image_path'])) {
                            $rightImagePath = $pair['right_image_path'];
                        }
                    } else {
                        $rightText = ! empty($pair['right_text']) ? $pair['right_text'] : null;
                    }

                    if ($leftText !== null || $rightText !== null || $rightImagePath !== null) {
                        $question->matchPairs()->create([
                            'left_text' => $leftText,
                            'right_text' => $rightText,
                            'right_image_path' => $rightImagePath,
                            'is_distractor' => $pair['is_distractor'] ?? false,
                        ]);
                    }
                }
            }
        }
        $this->dispatch('cleanup-test-tinymce');
        $this->showModal = false;
        $this->resetForm();
        session()->flash('message', 'Тест успешно сохранён.');
    }

    public function delete($id)
    {
        $test = Test::find($id);
        if ($test) {
            $test->delete();
            session()->flash('message', 'Тест удалён.');
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->description = '';
        $this->order = 0;
        $this->questions = [];
        $this->matchPairImages = [];
        $this->collapsedQuestions = [];
    }

    public function render()
    {
        $tests = Test::orderBy('order')->get();

        return view('livewire.admin.tests.index', compact('tests'));
    }
}
