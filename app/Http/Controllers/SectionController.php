<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        $sections = Section::with([
            'subsections' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.theoryBlock',
            'subsections.practiceBlocks' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.homeworkBlock',
            'subsections.controlBlocks' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.subSubsections' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.subSubsections.theoryBlock',
            'subsections.subSubsections.practiceBlocks' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.subSubsections.homeworkBlock',
            'subsections.subSubsections.controlBlocks' => function ($query) {
                $query->orderBy('order');
            },
        ])->orderBy('order')->get();

        return view('pages.sections.index', compact('sections'));
    }

    public function show(Section $section): View
    {
        $section->load([
            'subsections',
            'subsections.theoryBlock',
            'subsections.practiceBlocks' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.homeworkBlock',
            'subsections.controlBlocks' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.subSubsections' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.subSubsections.theoryBlock',
            'subsections.subSubsections.practiceBlocks' => function ($query) {
                $query->orderBy('order');
            },
            'subsections.subSubsections.homeworkBlock',
            'subsections.subSubsections.controlBlocks' => function ($query) {
                $query->orderBy('order');
            },
        ]);

        return view('pages.sections.show', compact('section'));
    }
}
