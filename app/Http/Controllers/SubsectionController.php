<?php

namespace App\Http\Controllers;

use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubsectionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Subsection $subsection): View
    {
        // Загружаем все связанные блоки контента и их элементы
        $subsection->load([
            'section', // Для хлебных крошек и контекста
            'theoryBlock.elements',
            'practiceBlocks.elements',
            'homeworkBlock.elements',
            'controlBlocks.elements',
            'controlBlocks.test.questions' // Загружаем назначенные тесты с вопросами
        ]);

        return view('pages.subsections.show', compact('subsection'));
    }
}
