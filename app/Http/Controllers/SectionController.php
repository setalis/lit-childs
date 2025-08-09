<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sections = Section::with([
            'subsections' => function($query) {
                $query->orderBy('order');
            },
            'subsections.theoryBlock',
            'subsections.practiceBlocks' => function($query) {
                $query->orderBy('order');
            },
            'subsections.homeworkBlock',
            'subsections.controlBlocks' => function($query) {
                $query->orderBy('order');
            }
        ])->orderBy('order')->get();
        
        return view('pages.sections.index', compact('sections'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section): View
    {
        // Загружаем подразделы вместе с разделом, если они еще не загружены
        $section->load('subsections'); 
        return view('pages.sections.show', compact('section')); // Путь к view может измениться
    }
}
