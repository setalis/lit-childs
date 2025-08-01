<?php

namespace App\Livewire\Admin\Subsections;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Subsection;
use App\Models\BlockElement;

class ManageContent extends Component
{
    use WithFileUploads;
    
    public $subsection;
    public $showBlockElementModal = false;
    public $showPracticeBlockModal = false;
    public $editingBlockElementId = null;
    public $elementType = null;
    public $elementOrder = null;
    public $elementContentText = '';
    public $elementContentKeywords = '';
    public $elementContentList = '';
    public $elementContentImage = null;
    public $existingElementImage = null;
    public $editingPracticeBlockId = null;
    public $practiceBlockLevel = null;
    public $practiceBlockOrder = null;
    public $showDeleteBlockElementModal = false;
    public $showDeletePracticeBlockModal = false;
    public $showPracticeBlockDeleteModal = false;
    public $showDeleteModal = false;
    public $currentBlockType = null;
    public $currentBlockId = null;

    public $selectedTestIds = [];
    public $allTests = [];

    public $activeKnowledgeBlockId = null;
    public $activeKnowledgeAction = null;
    public $showCreateControlBlockModal = false;

    public function mount($subsection)
    {
        $this->subsection = Subsection::with([
            'section',
            'theoryBlock.elements',
            'practiceBlocks.elements',
            'homeworkBlock.elements',
            'controlBlocks.elements'
        ])->findOrFail($subsection);
        $this->allTests = \App\Models\Test::orderBy('title')->get();
        
        // Заполняем выбранные тесты для каждого блока контроля знаний
        foreach ($this->subsection->controlBlocks as $block) {
            $this->selectedTestIds[$block->id] = $block->test_id;
        }
    }

    public function openCreateBlockElementModal($blockType = null, $blockId = null)
    {
        $this->resetBlockElementForm();
        $this->currentBlockType = $blockType;
        $this->currentBlockId = $blockId;
        $this->showBlockElementModal = true;
        if ($this->elementType === 'text' || is_null($this->elementType)) {
            $this->dispatch('init-tinymce');
        }
    }

    public function openEditBlockElementModal($elementId, $blockType = null, $blockId = null)
    {
        $element = BlockElement::findOrFail($elementId);
        $this->editingBlockElementId = $elementId;
        $this->elementType = $element->element_type;
        $this->elementOrder = $element->order;
        if ($element->element_type === 'text') {
            $this->elementContentText = $element->content;
        } elseif ($element->element_type === 'keywords') {
            $this->elementContentKeywords = $element->content;
        } elseif ($element->element_type === 'list') {
            $this->elementContentList = is_array(json_decode($element->content, true)) ? implode("\n", json_decode($element->content, true)) : $element->content;
        } elseif ($element->element_type === 'image') {
            $this->existingElementImage = $element->content;
        }
        $this->currentBlockType = $blockType;
        $this->currentBlockId = $blockId;
        $this->showBlockElementModal = true;
        if ($this->elementType === 'text') {
            $this->dispatch('init-tinymce');
        }
    }

    public function closeBlockElementModal()
    {
        $this->showBlockElementModal = false;
        $this->resetBlockElementForm();
        $this->dispatch('cleanup-tinymce');
    }

    public function saveBlockElement()
    {
        $rules = [
            'elementType' => 'required|in:text,keywords,list,image',
            'elementOrder' => 'required|integer|min:0',
        ];
        if ($this->elementType === 'text') {
            $rules['elementContentText'] = 'required|string';
        } elseif ($this->elementType === 'keywords') {
            $rules['elementContentKeywords'] = 'required|string';
        } elseif ($this->elementType === 'list') {
            $rules['elementContentList'] = 'required|string';
        } elseif ($this->elementType === 'image') {
            if ($this->editingBlockElementId && !$this->elementContentImage) {
                // При редактировании изображение не обязательно, если уже есть
            } else {
                $rules['elementContentImage'] = 'required|image|max:2048';
            }
        }
        $this->validate($rules);

        // Определяем content
        $content = null;
        if ($this->elementType === 'text') {
            $content = $this->elementContentText;
        } elseif ($this->elementType === 'keywords') {
            $content = $this->elementContentKeywords;
        } elseif ($this->elementType === 'list') {
            // Сохраняем список как JSON-массив
            $lines = array_filter(array_map('trim', explode("\n", $this->elementContentList)));
            $content = json_encode($lines, JSON_UNESCAPED_UNICODE);
        } elseif ($this->elementType === 'image') {
            if ($this->elementContentImage) {
                $content = $this->elementContentImage->store('block-elements', 'public');
            } elseif ($this->existingElementImage) {
                $content = $this->existingElementImage;
            }
        }

        // Определяем модель блока
        $blockModel = null;
        if ($this->currentBlockType === 'theory') {
            $blockModel = $this->subsection->theoryBlock;
        } elseif ($this->currentBlockType === 'practice') {
            $blockModel = $this->subsection->practiceBlocks->find($this->currentBlockId);
        } elseif ($this->currentBlockType === 'homework') {
            $blockModel = $this->subsection->homeworkBlock;
        } elseif ($this->currentBlockType === 'control') {
            $blockModel = $this->subsection->controlBlocks->find($this->currentBlockId);
        }
        if (!$blockModel) {
            session()->flash('error', 'Блок не найден.');
            return;
        }

        if ($this->editingBlockElementId) {
            $element = BlockElement::findOrFail($this->editingBlockElementId);
            $element->update([
                'element_type' => $this->elementType,
                'content' => $content,
                'order' => $this->elementOrder,
            ]);
        } else {
            $blockModel->elements()->create([
                'element_type' => $this->elementType,
                'content' => $content,
                'order' => $this->elementOrder,
            ]);
        }
        $this->showBlockElementModal = false;
        $this->resetBlockElementForm();
        session()->flash('message', 'Елемент блоку успішно збережено.');
    }

    public function deleteBlockElement($elementId)
    {
        $element = BlockElement::find($elementId);
        if ($element) {
            $element->delete();
            session()->flash('message', 'Елемент блоку видалено.');
        }
        $this->showBlockElementModal = false;
    }

    private function resetBlockElementForm()
    {
        $this->editingBlockElementId = null;
        $this->elementType = null;
        $this->elementOrder = null;
        $this->elementContentText = '';
        $this->elementContentKeywords = '';
        $this->elementContentList = '';
        $this->elementContentImage = null;
        $this->existingElementImage = null;
        $this->currentBlockType = null;
        $this->currentBlockId = null;
    }

    // --- Методы для практических блоков ---
    public function openCreatePracticeBlockModal()
    {
        $this->resetPracticeBlockForm();
        $this->showPracticeBlockModal = true;
    }

    public function openEditPracticeBlockModal($blockId)
    {
        $block = $this->subsection->practiceBlocks->find($blockId);
        if ($block) {
            $this->editingPracticeBlockId = $blockId;
            $this->practiceBlockLevel = $block->level;
            $this->practiceBlockOrder = $block->order;
        }
        $this->showPracticeBlockModal = true;
    }

    public function closePracticeBlockModal()
    {
        $this->showPracticeBlockModal = false;
        $this->resetPracticeBlockForm();
    }

    public function savePracticeBlock()
    {
        $this->validate([
            'practiceBlockLevel' => 'required|in:reproductive,constructive,creative',
            'practiceBlockOrder' => 'required|integer|min:1',
        ]);

        if ($this->editingPracticeBlockId) {
            // Редактирование существующего блока
            $block = $this->subsection->practiceBlocks->find($this->editingPracticeBlockId);
            if ($block) {
                $block->level = $this->practiceBlockLevel;
                $block->order = $this->practiceBlockOrder;
                $block->save();
                session()->flash('message', 'Практичний блок оновлено.');
            }
        } else {
            // Создание нового блока
            $this->subsection->practiceBlocks()->create([
                'level' => $this->practiceBlockLevel,
                'order' => $this->practiceBlockOrder,
            ]);
            session()->flash('message', 'Практичний блок створено.');
        }
        $this->showPracticeBlockModal = false;
        $this->resetPracticeBlockForm();
    }

    public function deletePracticeBlock($blockId)
    {
        $block = $this->subsection->practiceBlocks->find($blockId);
        if ($block) {
            $block->delete();
            session()->flash('message', 'Практичний блок видалено.');
        }
        $this->showPracticeBlockModal = false;
    }

    private function resetPracticeBlockForm()
    {
        $this->editingPracticeBlockId = null;
        $this->practiceBlockLevel = null;
        $this->practiceBlockOrder = null;
    }

    // --- Теоретический блок ---
    public function createTheoryBlock()
    {
        if (!$this->subsection->theoryBlock) {
            $this->subsection->theoryBlock()->create();
            session()->flash('message', 'Теоретичний блок створено.');
        } else {
            session()->flash('error', 'Теоретичний блок вже існує.');
        }
    }

    // --- Блок домашних заданий ---
    public function createHomeworkBlock()
    {
        if (!$this->subsection->homeworkBlock) {
            $this->subsection->homeworkBlock()->create();
            session()->flash('message', 'Блок завдань для самостійної роботи створено.');
        } else {
            session()->flash('error', 'Блок завдань для самостійної роботи вже існує.');
        }
    }

    public function updatedSelectedTestIds($value, $key)
    {
        // $key = control_block_id
        $block = \App\Models\ControlBlock::find($key);
        if ($block) {
            $block->test_id = $value ?: null;
            $block->save();
            $this->closeKnowledgeAction();
            session()->flash('message', 'Тест для блоку оновлено.');
        }
    }

    public function saveSelectedTest($blockId)
    {
        $block = \App\Models\ControlBlock::find($blockId);
        if ($block) {
            $testId = $this->selectedTestIds[$blockId] ?? null;
            $block->test_id = $testId ?: null;
            $block->save();
            $this->closeKnowledgeAction();
            session()->flash('message', 'Тест для блоку збережено.');
        }
    }

    public function resetTestForBlock($blockId)
    {
        $block = \App\Models\ControlBlock::find($blockId);
        if ($block) {
            $block->test_id = null;
            $block->save();
            $this->selectedTestIds[$blockId] = null;
            session()->flash('message', 'Тест для блоку скасовано.');
        }
    }

    public function selectKnowledgeElementType($type, $blockId = null)
    {
        if ($blockId) {
            $this->activeKnowledgeBlockId = $blockId;
        }
        
        if ($this->activeKnowledgeBlockId === null) {
            session()->flash('error', 'Не выбран блок для действия!');
            return;
        }
        
        $this->activeKnowledgeAction = $type;
    }

    public function closeKnowledgeAction()
    {
        $this->activeKnowledgeBlockId = null;
        $this->activeKnowledgeAction = null;
    }

    /**
     * Створити контрольний блок з тестовими завданнями
     */
    public function createTestControlBlock()
    {
        $maxOrder = $this->subsection->controlBlocks()->max('order') ?? 0;
        $this->subsection->controlBlocks()->create([
            'type' => \App\Models\ControlBlock::TYPE_TEST,
            'order' => $maxOrder + 1,
        ]);
        session()->flash('message', 'Блок контролю "Тестові завдання" створено.');
    }

    /**
     * Створити контрольний блок з питаннями та завданнями
     */
    public function createQuestionsControlBlock()
    {
        $maxOrder = $this->subsection->controlBlocks()->max('order') ?? 0;
        $this->subsection->controlBlocks()->create([
            'type' => \App\Models\ControlBlock::TYPE_QUESTIONS,
            'order' => $maxOrder + 1,
        ]);
        session()->flash('message', 'Блок контролю "Питання та завдання" створено.');
    }

    public function deleteControlBlock($blockId)
    {
        $block = \App\Models\ControlBlock::find($blockId);
        if ($block && $block->subsection_id === $this->subsection->id) {
            $block->delete();
            session()->flash('message', 'Блок контролю видалено.');
        }
    }

    public function render()
    {
        // Получаем связанные блоки
        $theoryBlock = $this->subsection->theoryBlock;
        $practiceBlocks = $this->subsection->practiceBlocks;
        $homeworkBlock = $this->subsection->homeworkBlock;
        $controlBlocks = $this->subsection->controlBlocks()->with(['test.questions', 'elements'])->get();

        // Уровни практики
        $availablePracticeLevels = [
            'reproductive' => 'Репродуктивний',
            'constructive' => 'Конструктивний',
            'creative' => 'Творчий',
        ];
        
        // Типы элементов блока
        $availableElementTypes = [
            'text' => 'Текст',
            'keywords' => 'Ключові слова',
            'list' => 'Список',
            'image' => 'Зображення',
        ];

        return view('livewire.admin.subsections.manage-content', [
            'subsection' => $this->subsection,
            'theoryBlock' => $theoryBlock,
            'practiceBlocks' => $practiceBlocks,
            'homeworkBlock' => $homeworkBlock,
            'controlBlocks' => $controlBlocks,
            'availablePracticeLevels' => $availablePracticeLevels,
            'availableElementTypes' => $availableElementTypes,
            'showBlockElementModal' => $this->showBlockElementModal,
            'showPracticeBlockModal' => $this->showPracticeBlockModal,
            'editingBlockElementId' => $this->editingBlockElementId,
            'elementType' => $this->elementType,
            'elementOrder' => $this->elementOrder,
            'elementContentText' => $this->elementContentText,
            'elementContentKeywords' => $this->elementContentKeywords,
            'elementContentList' => $this->elementContentList,
            'elementContentImage' => $this->elementContentImage,
            'existingElementImage' => $this->existingElementImage,
            'editingPracticeBlockId' => $this->editingPracticeBlockId,
            'practiceBlockLevel' => $this->practiceBlockLevel,
            'practiceBlockOrder' => $this->practiceBlockOrder,
            'selectedTestIds' => $this->selectedTestIds,
            'allTests' => $this->allTests,
            'activeKnowledgeBlockId' => $this->activeKnowledgeBlockId,
            'activeKnowledgeAction' => $this->activeKnowledgeAction,
            'showCreateControlBlockModal' => $this->showCreateControlBlockModal,
        ]);
    }
}
