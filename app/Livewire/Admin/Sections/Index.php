<?php

namespace App\Livewire\Admin\Sections;

use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination; // Для пагинации, если разделов будет много
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'order';
    public $sortDirection = 'asc';

    // Для модального окна подтверждения удаления
    public $showDeleteModal = false;
    public $deletingSectionId = null;
    public $deletingSectionTitle = '';

    // Для модального окна формы создания/редактирования
    public $showFormModal = false;
    public $editingSectionId = null;
    public $sectionTitle = '';
    public $sectionDescription = '';
    public $sectionOrder = 0;

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    protected function rules()
    {
        return [
            'sectionTitle' => ['required', 'string', 'max:255'],
            'sectionDescription' => ['nullable', 'string'],
            'sectionOrder' => ['required', 'integer', 'min:0'],
        ];
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
        $this->showFormModal = true;
        $this->dispatch('init-tinymce');
    }

    public function openEditModal($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $this->editingSectionId = $section->id;
        $this->sectionTitle = $section->title;
        $this->sectionDescription = $section->description;
        $this->sectionOrder = $section->order;
        $this->showFormModal = true;
        $this->dispatch('init-tinymce');
    }

    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->resetForm();
        $this->dispatch('cleanup-tinymce');
    }

    public function saveSection()
    {
        $this->validate();

        if ($this->editingSectionId) {
            // Редактирование
            $section = Section::find($this->editingSectionId);
            $section->update([
                'title' => $this->sectionTitle,
                'description' => $this->sectionDescription,
                'order' => $this->sectionOrder,
            ]);
            session()->flash('message', 'Розділ "' . $this->sectionTitle . '" успішно оновлено.');
        } else {
            // Создание
            Section::create([
                'title' => $this->sectionTitle,
                'description' => $this->sectionDescription,
                'order' => $this->sectionOrder,
            ]);
            session()->flash('message', 'Розділ "' . $this->sectionTitle . '" успішно створено.');
        }
        $this->closeFormModal();
    }

    private function resetForm()
    {
        $this->editingSectionId = null;
        $this->sectionTitle = '';
        $this->sectionDescription = '';
        $this->sectionOrder = 0;
        $this->resetErrorBag(); // Сброс ошибок валидации
    }
    // --- Конец методов для модального окна формы ---


    // --- Методы для модального окна удаления ---
    public function openDeleteModal($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $this->deletingSectionId = $section->id;
        $this->deletingSectionTitle = $section->title;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingSectionId = null;
        $this->deletingSectionTitle = '';
    }

    public function deleteSection()
    {
        if ($this->deletingSectionId) {
            $section = Section::find($this->deletingSectionId);
            if ($section) {
                $section->delete();
                session()->flash('message', 'Розділ "' . $this->deletingSectionTitle . '" успішно видалено.');
            }
            $this->closeDeleteModal();
        }
    }
    // --- Конец методов для модального окна удаления ---

    public function render()
    {
        $sections = Section::query()
            ->withCount('subsections') // Загружаем количество подразделов
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.sections.index', [
            'sections' => $sections,
        ])->layout('components.layouts.app');
    }
}
