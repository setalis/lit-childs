<?php

namespace App\Http\Controllers;

use App\Models\Subsection;
use App\Models\ControlBlock;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ControlBlockController extends Controller
{
    /**
     * Display all control blocks for subsection.
     */
    public function showAll(Subsection $subsection): View
    {
        // Завантажуємо необхідні дані
        $subsection->load(['section', 'controlBlocks.elements', 'controlBlocks.test.questions.answers', 'controlBlocks.test.questions.matchPairs']);

        return view('pages.blocks.control_all_show', compact('subsection'));
    }

    /**
     * Display the specified control block.
     */
    public function show(Subsection $subsection, ControlBlock $controlBlock): View
    {
        // Перевіряємо що контрольний блок належить цьому підрозділу
        if ($controlBlock->subsection_id !== $subsection->id) {
            abort(404);
        }

        // Завантажуємо необхідні дані
        $subsection->load('section');
        $controlBlock->load(['elements', 'test.questions.answers', 'test.questions.matchPairs']);

        return view('pages.blocks.control_show', compact('subsection', 'controlBlock'));
    }
}
