<?php

namespace App\Http\Controllers;

use App\Models\Subsection;
use Illuminate\View\View;

class SubsectionController extends Controller
{
    public function show(Subsection $subsection): View
    {
        $subsection->load([
            'section',
            'parent.section',
            'subSubsections' => function ($query) {
                $query->orderBy('order');
            },
            'subSubsections.theoryBlock',
            'subSubsections.practiceBlocks',
            'subSubsections.homeworkBlock',
            'subSubsections.controlBlocks',
            'theoryBlock.elements',
            'practiceBlocks.elements',
            'homeworkBlock.elements',
            'controlBlocks.elements',
            'controlBlocks.test.questions',
        ]);

        return view('pages.subsections.show', compact('subsection'));
    }
}
