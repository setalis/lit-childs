<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $sections = Section::orderBy('order')->get(); // Загружаем разделы для блока "РОЗДІЛИ ПІДРУЧНИКА"
        return view('pages.home', compact('sections'));
    }
} 