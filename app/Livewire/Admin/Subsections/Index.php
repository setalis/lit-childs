<?php

namespace App\Livewire\Admin\Subsections;

use App\Models\Section;
use App\Models\Subsection;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'order';
    public $sortDirection = 'asc';
    public $filterBySection = ''; // Для фильтрации по разделу

    // Для модального окна подтверждения удаления
    public $showDeleteModal = false;
    public $deletingSubsectionId = null;
    public $deletingSubsectionTitle = '';

    // Для модального окна формы создания/редактирования
    public $showFormModal = false;
    public $editingSubsectionId = null;
    public $subsectionTitle = '';
    public $subsectionOrder = 0;
    public $selectedSectionId = null; // ID выбранного родительского раздела

    public $sections = []; // Для списка разделов в форме

    protected $queryString = ['search', 'sortField', 'sortDirection', 'filterBySection'];

    protected function rules()
    {
        return [
            'subsectionTitle' => ['required', 'string', 'max:255'],
            'subsectionOrder' => ['required', 'integer', 'min:0'],
            'selectedSectionId' => ['required', 'exists:sections,id'],
        ];
    }

    public function mount()
    {
        $this->sections = Section::orderBy('title')->get();
        // Установка значения по умолчанию для selectedSectionId, если есть разделы
        if ($this->sections->isNotEmpty() && is_null($this->selectedSectionId)) {
             // Если фильтр по разделу активен, используем его, иначе первый раздел из списка
            if ($this->filterBySection && $this->sections->contains('id', $this->filterBySection)) {
                $this->selectedSectionId = $this->filterBySection;
            } elseif ($this->sections->first()) {
                $this->selectedSectionId = $this->sections->first()->id;
            }
        }
    }


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // --- Методы для модального окна формы ---
    public function openCreateModal()
    {
        $this->resetForm();
        // Если активен фильтр по разделу, предзаполняем его
        if ($this->filterBySection) {
            $this->selectedSectionId = $this->filterBySection;
        } elseif ($this->sections->isNotEmpty()) {
            $this->selectedSectionId = $this->sections->first()->id; // Предзаполняем первым разделом, если фильтр не активен
        }
        $this->showFormModal = true;
    }

    public function openEditModal($subsectionId)
    {
        $subsection = Subsection::findOrFail($subsectionId);
        $this->editingSubsectionId = $subsection->id;
        $this->subsectionTitle = $subsection->title;
        $this->subsectionOrder = $subsection->order;
        $this->selectedSectionId = $subsection->section_id;
        $this->showFormModal = true;
    }

    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->resetForm();
    }

    public function saveSubsection()
    {
        $this->validate();

        $data = [
            'title' => $this->subsectionTitle,
            'order' => $this->subsectionOrder,
            'section_id' => $this->selectedSectionId,
        ];

        if ($this->editingSubsectionId) {
            $subsection = Subsection::find($this->editingSubsectionId);
            $subsection->update($data);
            session()->flash('message', 'Підрозділ "' . $this->subsectionTitle . '" успішно оновлено.');
        } else {
            Subsection::create($data);
            session()->flash('message', 'Підрозділ "' . $this->subsectionTitle . '" успішно створено.');
        }
        $this->closeFormModal();
    }

    private function resetForm()
    {
        $this->editingSubsectionId = null;
        $this->subsectionTitle = '';
        $this->subsectionOrder = 0;
        // Не сбрасываем selectedSectionId, если активен фильтр, чтобы он оставался
        if (!$this->filterBySection && $this->sections->isNotEmpty()) {
            $this->selectedSectionId = $this->sections->first()->id;
        } elseif ($this->filterBySection) {
            $this->selectedSectionId = $this->filterBySection;
        } else {
            $this->selectedSectionId = null;
        }
        $this->resetErrorBag();
    }
    // --- Конец методов для модального окна формы ---


    // --- Методы для модального окна удаления ---
    public function openDeleteModal($subsectionId)
    {
        $subsection = Subsection::findOrFail($subsectionId);
        $this->deletingSubsectionId = $subsection->id;
        $this->deletingSubsectionTitle = $subsection->title;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingSubsectionId = null;
        $this->deletingSubsectionTitle = '';
    }

    public function deleteSubsection()
    {
        if ($this->deletingSubsectionId) {
            $subsection = Subsection::find($this->deletingSubsectionId);
            if ($subsection) {
                $subsection->delete();
                session()->flash('message', 'Підрозділ "' . $this->deletingSubsectionTitle . '" успішно видалено.');
            }
            $this->closeDeleteModal();
        }
    }
    // --- Конец методов для модального окна удаления ---

    public function updatedFilterBySection()
    {
        $this->resetPage(); // Сбрасываем пагинацию при изменении фильтра
        // При смене фильтра, если открыта форма создания, обновляем selectedSectionId
        if ($this->showFormModal && !$this->editingSubsectionId) {
            $this->selectedSectionId = $this->filterBySection ?: ($this->sections->isNotEmpty() ? $this->sections->first()->id : null);
        }
    }
    
    public function render()
    {
        $subsections = Subsection::query()
            ->with('section') // Загружаем связанный раздел
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterBySection, function ($query) {
                $query->where('section_id', $this->filterBySection);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.subsections.index', [
            'subsections' => $subsections,
            'allSections' => $this->sections, // Передаем все разделы для фильтра и формы
        ])->layout('components.layouts.app');
    }
}
