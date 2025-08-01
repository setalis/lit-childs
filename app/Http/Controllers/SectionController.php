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
        $sections = Section::orderBy('order')->get();
        return view('pages.sections.index', compact('sections')); // Путь к view может измениться
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
