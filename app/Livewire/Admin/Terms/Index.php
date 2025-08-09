<?php

namespace App\Livewire\Admin\Terms;

use App\Models\Term;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $termToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($termId)
    {
        $this->termToDelete = Term::find($termId);
    }

    public function deleteTerm()
    {
        if ($this->termToDelete) {
            // Удаляем изображение
            if ($this->termToDelete->image_path) {
                Storage::disk('public')->delete($this->termToDelete->image_path);
            }

            $this->termToDelete->delete();

            // Обновляем кеш терминов для автоматических ссылок
            if (app()->bound(\App\Services\FigureLinkService::class)) {
                app(\App\Services\FigureLinkService::class)->refreshTerms();
            }

            session()->flash('message', 'Термін успішно видалено.');
            $this->termToDelete = null;
        }
    }

    public function render()
    {
        $terms = Term::with('definitions')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('definitions', function ($q) {
                          $q->where('definition', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('livewire.admin.terms.index', compact('terms'));
    }
}
