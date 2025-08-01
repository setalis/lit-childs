<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.terms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.terms.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term): View
    {
        return view('admin.terms.edit', compact('term'));
    }
}
