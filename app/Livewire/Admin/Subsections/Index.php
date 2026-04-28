<?php

namespace App\Livewire\Admin\Subsections;

use App\Models\Section;
use App\Models\Subsection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $sortField = 'order';

    public $sortDirection = 'asc';

    public $filterBySection = '';

    public $showDeleteModal = false;

    public $deletingSubsectionId = null;

    public $deletingSubsectionTitle = '';

    public $showFormModal = false;

    public $editingSubsectionId = null;

    public $subsectionTitle = '';

    public $subsectionOrder = 0;

    public $selectedSectionId = null;

    public $parentSubsectionId = null;

    public $sections = [];

    protected $queryString = ['search', 'sortField', 'sortDirection', 'filterBySection'];

    protected function rules(): array
    {
        return [
            'subsectionTitle' => ['required', 'string', 'max:255'],
            'subsectionOrder' => ['required', 'integer', 'min:0'],
            'selectedSectionId' => $this->parentSubsectionId
                ? ['nullable']
                : ['required', 'exists:sections,id'],
            'parentSubsectionId' => ['nullable', 'exists:subsections,id'],
        ];
    }

    public function mount(): void
    {
        $this->sections = Section::orderBy('title')->get();

        if ($this->sections->isNotEmpty() && is_null($this->selectedSectionId)) {
            if ($this->filterBySection && $this->sections->contains('id', $this->filterBySection)) {
                $this->selectedSectionId = $this->filterBySection;
            } elseif ($this->sections->first()) {
                $this->selectedSectionId = $this->sections->first()->id;
            }
        }
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        if ($this->filterBySection) {
            $this->selectedSectionId = $this->filterBySection;
        } elseif ($this->sections->isNotEmpty()) {
            $this->selectedSectionId = $this->sections->first()->id;
        }
        $this->showFormModal = true;
    }

    public function openCreateSubSubsectionModal(int $parentId): void
    {
        $this->resetForm();
        $this->parentSubsectionId = $parentId;
        $this->showFormModal = true;
    }

    public function openEditModal(int $subsectionId): void
    {
        $subsection = Subsection::findOrFail($subsectionId);
        $this->editingSubsectionId = $subsection->id;
        $this->subsectionTitle = $subsection->title;
        $this->subsectionOrder = $subsection->order;
        $this->parentSubsectionId = $subsection->parent_id;
        $this->selectedSectionId = $subsection->parent_id ? null : $subsection->section_id;
        $this->showFormModal = true;
    }

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
        $this->resetForm();
    }

    public function saveSubsection(): void
    {
        $this->validate();

        if ($this->parentSubsectionId) {
            $parent = Subsection::findOrFail($this->parentSubsectionId);
            $sectionId = $parent->section_id;
        } else {
            $sectionId = $this->selectedSectionId;
        }

        $data = [
            'title' => $this->subsectionTitle,
            'order' => $this->subsectionOrder,
            'section_id' => $sectionId,
            'parent_id' => $this->parentSubsectionId ?: null,
        ];

        if ($this->editingSubsectionId) {
            $subsection = Subsection::find($this->editingSubsectionId);
            $subsection->update($data);
            session()->flash('message', 'Підрозділ "'.$this->subsectionTitle.'" успішно оновлено.');
        } else {
            Subsection::create($data);
            session()->flash('message', 'Підрозділ "'.$this->subsectionTitle.'" успішно створено.');
        }
        $this->closeFormModal();
    }

    private function resetForm(): void
    {
        $this->editingSubsectionId = null;
        $this->subsectionTitle = '';
        $this->subsectionOrder = 0;
        $this->parentSubsectionId = null;

        if (! $this->filterBySection && $this->sections->isNotEmpty()) {
            $this->selectedSectionId = $this->sections->first()->id;
        } elseif ($this->filterBySection) {
            $this->selectedSectionId = $this->filterBySection;
        } else {
            $this->selectedSectionId = null;
        }
        $this->resetErrorBag();
    }

    public function openDeleteModal(int $subsectionId): void
    {
        $subsection = Subsection::findOrFail($subsectionId);
        $this->deletingSubsectionId = $subsection->id;
        $this->deletingSubsectionTitle = $subsection->title;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingSubsectionId = null;
        $this->deletingSubsectionTitle = '';
    }

    public function deleteSubsection(): void
    {
        if ($this->deletingSubsectionId) {
            $subsection = Subsection::find($this->deletingSubsectionId);
            if ($subsection) {
                $subsection->delete();
                session()->flash('message', 'Підрозділ "'.$this->deletingSubsectionTitle.'" успішно видалено.');
            }
            $this->closeDeleteModal();
        }
    }

    public function updatedFilterBySection(): void
    {
        $this->resetPage();
        if ($this->showFormModal && ! $this->editingSubsectionId) {
            $this->selectedSectionId = $this->filterBySection ?: ($this->sections->isNotEmpty() ? $this->sections->first()->id : null);
        }
    }

    public function render()
    {
        $subsections = Subsection::query()
            ->with(['section', 'subSubsections.section'])
            ->whereNull('parent_id')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhereHas('subSubsections', function ($q) {
                        $q->where('title', 'like', '%'.$this->search.'%');
                    });
            })
            ->when($this->filterBySection, function ($query) {
                $query->where('section_id', $this->filterBySection);
            })
            ->orderBy('section_id')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $parentSubsections = Subsection::query()
            ->whereNull('parent_id')
            ->with('section')
            ->orderBy('section_id')
            ->orderBy('order')
            ->get();

        return view('livewire.admin.subsections.index', [
            'subsections' => $subsections,
            'allSections' => $this->sections,
            'parentSubsections' => $parentSubsections,
        ])->layout('components.layouts.app');
    }
}
