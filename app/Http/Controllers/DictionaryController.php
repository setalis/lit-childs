<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // Для получения уникальных первых букв

class DictionaryController extends Controller
{
    public function index(Request $request): View
    {
        $selectedLetter = $request->get('letter');

        $query = Term::orderBy('name');

        if ($selectedLetter) {
            // Используем виртуальное поле first_letter для фильтрации
            $query->where('first_letter', $selectedLetter);
        }

        $terms = $query->get()->groupBy('first_letter');

        // Получаем все уникальные первые буквы из таблицы terms для панели фильтров
        // Отсортируем их для корректного отображения
        $letters = Term::select('first_letter')
                        ->distinct()
                        ->orderBy('first_letter')
                        ->pluck('first_letter');

        return view('pages.dictionary.index', compact('terms', 'letters', 'selectedLetter'));
    }
}
