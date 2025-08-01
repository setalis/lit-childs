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

    public function showHomework(Subsection $subsection)
    {
        $homeworkBlock = $subsection->homeworkBlock()->with('elements')->firstOrFail();
        return view('pages.blocks.homework_show', compact('subsection', 'homeworkBlock'));
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