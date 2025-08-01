<?php

namespace App\Http\Controllers;

use App\Models\Figure;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FigureController extends Controller
{
    public function index(Request $request): View
    {
        $selectedLetter = $request->get('letter');

        $query = Figure::orderBy('last_name')->orderBy('first_name');

        if ($selectedLetter) {
            $query->where('first_letter', $selectedLetter);
        }

        $figures = $query->get()->groupBy('first_letter');

        $letters = Figure::select('first_letter')
                        ->distinct()
                        ->orderBy('first_letter')
                        ->pluck('first_letter')
                        ->filter(); // Убираем пустые значения

        return view('pages.figures.index', compact('figures', 'letters', 'selectedLetter'));
    }

    public function show(Figure $figure): View
    {
        return view('pages.figures.show', compact('figure'));
    }

    public function create(): View
    {
        return view('admin.figures.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'biography' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Создаем полное имя для обратной совместимости
        $validated['name'] = trim($validated['first_name'] . ' ' . $validated['last_name']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('figures', 'public');
            $validated['image_path'] = $path;
        }

        Figure::create($validated);

        // Обновляем кеш персоналий для автоматических ссылок
        app(\App\Services\FigureLinkService::class)->refreshFigures();

        return redirect()->route('admin.figures.index')->with('success', 'Персоналію успішно додано');
    }

    public function edit(Figure $figure): View
    {
        return view('admin.figures.edit', compact('figure'));
    }

    public function update(Request $request, Figure $figure): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'biography' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обновляем полное имя для обратной совместимости
        $validated['name'] = trim($validated['first_name'] . ' ' . $validated['last_name']);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($figure->image_path) {
                Storage::disk('public')->delete($figure->image_path);
            }
            
            $path = $request->file('image')->store('figures', 'public');
            $validated['image_path'] = $path;
        }

        $figure->update($validated);

        // Обновляем кеш персоналий для автоматических ссылок
        app(\App\Services\FigureLinkService::class)->refreshFigures();

        return redirect()->route('admin.figures.index')->with('success', 'Персоналію успішно оновлено');
    }

    public function destroy(Figure $figure): RedirectResponse
    {
        // Удаляем изображение
        if ($figure->image_path) {
            Storage::disk('public')->delete($figure->image_path);
        }

        $figure->delete();

        // Обновляем кеш персоналий для автоматических ссылок
        app(\App\Services\FigureLinkService::class)->refreshFigures();

        return redirect()->route('admin.figures.index')->with('success', 'Персоналію успішно видалено');
    }
}
