<?php

namespace App\Livewire\Admin\Figures;

use App\Models\Figure;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $figureToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($figureId)
    {
        $this->figureToDelete = Figure::find($figureId);
    }

    public function deleteFigure()
    {
        if ($this->figureToDelete) {
            // Удаляем изображение
            if ($this->figureToDelete->image_path) {
                Storage::disk('public')->delete($this->figureToDelete->image_path);
            }

            $this->figureToDelete->delete();

            // Обновляем кеш персоналий для автоматических ссылок
            app(\App\Services\FigureLinkService::class)->refreshFigures();

            session()->flash('message', 'Персоналію успішно видалено.');
            $this->figureToDelete = null;
        }
    }

    public function render()
    {
        $figures = Figure::query()
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('biography', 'like', '%' . $this->search . '%');
            })
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->paginate(15);

        return view('livewire.admin.figures.index', compact('figures'));
    }
} 