<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $selectedLetter = $request->get('letter');

        $query = Term::orderBy('name');

        if ($selectedLetter) {
            $query->where('first_letter', $selectedLetter);
        }

        $terms = $query->get()->groupBy('first_letter');

        $letters = Term::select('first_letter')
                      ->distinct()
                      ->orderBy('first_letter')
                      ->pluck('first_letter')
                      ->filter(); // Убираем пустые значения

        return view('pages.terms.index', compact('terms', 'letters', 'selectedLetter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'definition' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('terms', 'public');
            $validated['image_path'] = $imagePath;
        }

        Term::create($validated);

        // Обновляем кеш терминов для автоматических ссылок
        if (app()->bound(\App\Services\FigureLinkService::class)) {
            app(\App\Services\FigureLinkService::class)->refreshTerms();
        }

        return redirect()->route('admin.terms.index')->with('success', 'Термін успішно створено.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $term): View
    {
        return view('pages.terms.show', compact('term'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term): View
    {
        return view('admin.terms.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'definition' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($term->image_path) {
                Storage::disk('public')->delete($term->image_path);
            }
            
            $imagePath = $request->file('image')->store('terms', 'public');
            $validated['image_path'] = $imagePath;
        }

        $term->update($validated);

        // Обновляем кеш терминов для автоматических ссылок
        if (app()->bound(\App\Services\FigureLinkService::class)) {
            app(\App\Services\FigureLinkService::class)->refreshTerms();
        }

        return redirect()->route('admin.terms.index')->with('success', 'Термін успішно оновлено.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term): RedirectResponse
    {
        // Удаляем изображение
        if ($term->image_path) {
            Storage::disk('public')->delete($term->image_path);
        }

        $term->delete();

        // Обновляем кеш терминов для автоматических ссылок
        if (app()->bound(\App\Services\FigureLinkService::class)) {
            app(\App\Services\FigureLinkService::class)->refreshTerms();
        }

        return redirect()->route('admin.terms.index')->with('success', 'Термін успішно видалено.');
    }
}
