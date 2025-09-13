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

        // Получаем все персоналии
        $allFigures = Figure::orderBy('last_name')->orderBy('first_name')->get();

        // Группируем по первой букве используя PHP
        $figures = $allFigures->groupBy(function($figure) {
            // Получаем первую букву фамилии в верхнем регистре
            return mb_strtoupper(mb_substr($figure->last_name, 0, 1, 'UTF-8'), 'UTF-8');
        });

        // Если выбрана определенная буква, фильтруем
        if ($selectedLetter) {
            $figures = $figures->filter(function($group, $letter) use ($selectedLetter) {
                return $letter === $selectedLetter;
            });
        }

        // Правильная сортировка украинского алфавита
        $ukrainianAlphabet = [
            'А', 'Б', 'В', 'Г', 'Ґ', 'Д', 'Е', 'Є', 'Ж', 'З', 'И', 'І', 'Ї', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ь', 'Ю', 'Я'
        ];

        // Сортируем группы по украинскому алфавиту
        $figures = $figures->sortBy(function($group, $letter) use ($ukrainianAlphabet) {
            $index = array_search($letter, $ukrainianAlphabet);
            return $index !== false ? $index : 999; // Неизвестные символы в конец
        });

        // Получаем все уникальные буквы для навигации и сортируем по украинскому алфавиту
        $letters = $allFigures->map(function($figure) {
            return mb_strtoupper(mb_substr($figure->last_name, 0, 1, 'UTF-8'), 'UTF-8');
        })->unique()->sortBy(function($letter) use ($ukrainianAlphabet) {
            $index = array_search($letter, $ukrainianAlphabet);
            return $index !== false ? $index : 999; // Неизвестные символы в конец
        })->values();

        return view('pages.figures.index', compact('figures', 'letters', 'selectedLetter'));
    }

    public function show(Figure $figure): View
    {
        // Загружаем блоки с сортировкой по порядку
        $figure->load(['blocks' => function($query) {
            $query->orderBy('order');
        }]);
        
        return view('pages.figures.show', compact('figure'));
    }

    public function create(): View
    {
        return view('admin.figures.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'biography' => 'required|string',
            'sources' => 'required|string',
            'biography_2' => 'nullable|string',
            'sources_2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blocks' => 'nullable|array',
            'blocks.*.type' => 'required|in:biography,sources',
            'blocks.*.content' => 'required|string|min:10',
            'blocks.*.order' => 'nullable|integer|min:0',
        ]);

        // Убираем обратную совместимость с полем name

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('figures', 'public');
            $validated['image_path'] = $path;
        }

        // Создаем персоналию
        $figure = Figure::create($validated);

        // Создаем блоки
        if (isset($validated['blocks'])) {
            foreach ($validated['blocks'] as $blockKey => $blockData) {
                // Обрабатываем блоки с ID вида biography_X или source_X
                if (preg_match('/^(biography|source)_\d+$/', $blockKey)) {
                    $figure->blocks()->create([
                        'type' => $blockData['type'],
                        'content' => $blockData['content'],
                        'order' => $blockData['order'] ?? 0,
                    ]);
                }
            }
        }

        // Обновляем кеш персоналий для автоматических ссылок
        app(\App\Services\FigureLinkService::class)->refreshFigures();

        return redirect()->route('admin.figures.index')->with('success', 'Персоналію успішно додано');
    }

    public function edit(Figure $figure): View
    {
        // Загружаем блоки с сортировкой по порядку
        $figure->load(['blocks' => function($query) {
            $query->orderBy('order');
        }]);
        
        return view('admin.figures.edit', compact('figure'));
    }

    public function update(Request $request, Figure $figure): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'biography' => 'required|string',
            'sources' => 'required|string',
            'biography_2' => 'nullable|string',
            'sources_2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blocks' => 'nullable|array',
            'blocks.*.type' => 'required|in:biography,sources',
            'blocks.*.content' => 'required|string|min:10',
            'blocks.*.order' => 'nullable|integer|min:0',
        ]);

        // Обновляем полное имя для обратной совместимости
        $validated['name'] = trim(($validated['first_name'] ?? '') . ' ' . $validated['last_name']);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($figure->image_path) {
                Storage::disk('public')->delete($figure->image_path);
            }
            
            $path = $request->file('image')->store('figures', 'public');
            $validated['image_path'] = $path;
        }

        $figure->update($validated);

        // Обновляем блоки
        if (isset($validated['blocks'])) {
            // Получаем ID существующих блоков
            $existingBlockIds = $figure->blocks->pluck('id')->toArray();
            $updatedBlockIds = [];
            
            foreach ($validated['blocks'] as $blockKey => $blockData) {
                // Если это существующий блок (есть ID)
                if (isset($blockData['id']) && is_numeric($blockData['id'])) {
                    $block = $figure->blocks()->find($blockData['id']);
                    if ($block) {
                        $block->update([
                            'type' => $blockData['type'],
                            'content' => $blockData['content'],
                            'order' => $blockData['order'] ?? 0,
                        ]);
                        $updatedBlockIds[] = $block->id;
                    }
                } elseif (preg_match('/^(biography|source)_\d+$/', $blockKey)) {
                    // Это новый блок с ID вида biography_X или source_X
                    $newBlock = $figure->blocks()->create([
                        'type' => $blockData['type'],
                        'content' => $blockData['content'],
                        'order' => $blockData['order'] ?? 0,
                    ]);
                    $updatedBlockIds[] = $newBlock->id;
                }
            }
            
            // Удаляем блоки, которые не были обновлены
            $blocksToDelete = array_diff($existingBlockIds, $updatedBlockIds);
            if (!empty($blocksToDelete)) {
                $figure->blocks()->whereIn('id', $blocksToDelete)->delete();
            }
        } else {
            // Если блоков нет, удаляем все существующие
            $figure->blocks()->delete();
        }

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
