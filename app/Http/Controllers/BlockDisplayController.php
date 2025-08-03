<?php

namespace App\Http\Controllers;

use App\Models\Subsection;
use App\Models\PracticeBlock;
use App\Models\ControlBlock;
use Illuminate\Http\Request;

class BlockDisplayController extends Controller
{
    public function showTheory(Subsection $subsection)
    {
        $theoryBlock = $subsection->theoryBlock()->with('elements')->firstOrFail();
        return view('pages.blocks.theory_show', compact('subsection', 'theoryBlock'));
    }

    public function showPractice(Subsection $subsection, PracticeBlock $practiceBlock)
    {
        // Убедимся, что практика принадлежит этому подразделу
        if ($practiceBlock->subsection_id !== $subsection->id) {
            abort(404);
        }
        $practiceBlock->load('elements');
        return view('pages.blocks.practice_show', compact('subsection', 'practiceBlock'));
    }

    public function showAllPractice(Subsection $subsection, Request $request)
    {
        // Загружаем все практические блоки с их элементами, сгруппированные по уровню
        $practiceBlocks = $subsection->practiceBlocks()
            ->with('elements')
            ->orderBy('order')
            ->get()
            ->groupBy('level');



        // Получаем ID блока для перехода, если указан
        $targetBlockId = $request->get('block_id');

        return view('pages.blocks.practice_all_show', compact('subsection', 'practiceBlocks', 'targetBlockId'));
    }

    public function showHomework(Subsection $subsection)
    {
        $homeworkBlock = $subsection->homeworkBlock()->with('elements')->firstOrFail();
        return view('pages.blocks.homework_show', compact('subsection', 'homeworkBlock'));
    }

    public function showAllControl(Subsection $subsection, Request $request)
    {
        // Загружаем все контрольные блоки с их элементами
        $controlBlocks = $subsection->controlBlocks()
            ->with('elements')
            ->orderBy('order')
            ->get();

        // Получаем ID блока для перехода, если указан
        $targetBlockId = $request->get('block_id');

        return view('pages.blocks.control_all_show', compact('subsection', 'controlBlocks', 'targetBlockId'));
    }

    public function showControl(Subsection $subsection, ControlBlock $controlBlock)
    {
        // Убедимся, что контрольный блок принадлежит этому подразделу
        if ($controlBlock->subsection_id !== $subsection->id) {
            abort(404);
        }
        $controlBlock->load('elements');
        return view('pages.blocks.control_show', compact('subsection', 'controlBlock'));
    }
} 