<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Figure;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FigureController extends Controller
{
    public function index(): View
    {
        $figures = Figure::orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.figures.index', compact('figures'));
    }

    public function create(): View
    {
        return view('admin.figures.create');
    }

    public function edit(Figure $figure): View
    {
        return view('admin.figures.edit', compact('figure'));
    }
} 