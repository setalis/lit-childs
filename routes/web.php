<?php

use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubsectionController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\FigureController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\Admin\FigureController as AdminFigureController;
use App\Http\Controllers\Admin\TermController as AdminTermController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlockDisplayController;
use App\Http\Controllers\ControlBlockController;
use App\Http\Controllers\TinyMCEImageController;
use App\Livewire\Admin\Sections\Index as AdminSectionsIndex;
use App\Livewire\Admin\Subsections\Index as AdminSubsectionsIndex;
use App\Livewire\Admin\Subsections\ManageContent as AdminSubsectionsManageContent;
use App\Livewire\Admin\Figures\Index as AdminFiguresIndex;
use App\Livewire\Admin\Terms\Index as AdminTermsIndex;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');

Route::get('/subsections/{subsection}', [SubsectionController::class, 'show'])->name('subsections.show');

Route::get('/subsections/{subsection}/theory', [BlockDisplayController::class, 'showTheory'])->name('blocks.theory.show');
Route::get('/subsections/{subsection}/practice', [BlockDisplayController::class, 'showAllPractice'])->name('blocks.practice.all');
Route::get('/subsections/{subsection}/practice/{practiceBlock}', [BlockDisplayController::class, 'showPractice'])->name('blocks.practice.show');
Route::get('/subsections/{subsection}/homework', [BlockDisplayController::class, 'showHomework'])->name('blocks.homework.show');
Route::get('/subsections/{subsection}/control', [ControlBlockController::class, 'showAll'])->name('blocks.control.all');
Route::get('/subsections/{subsection}/control/{controlBlock}', [ControlBlockController::class, 'show'])->name('blocks.control.show');

Route::get('/dictionary', [DictionaryController::class, 'index'])->name('dictionary.index');

Route::get('/figures', [FigureController::class, 'index'])->name('figures.index');
Route::get('/figures/{figure}', [FigureController::class, 'show'])->name('figures.show');

Route::get('/terms', [TermController::class, 'index'])->name('terms.index');
Route::get('/terms/{term}', [TermController::class, 'show'])->name('terms.show');

Route::get('/test/{test}', [\App\Http\Controllers\TestController::class, 'show'])->name('test.show');
Route::post('/test/{test}/submit', [\App\Http\Controllers\TestController::class, 'submit'])->name('test.submit');

Route::post('/tinymce/upload-image', [TinyMCEImageController::class, 'upload'])->name('tinymce.upload-image');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/sections', AdminSectionsIndex::class)->name('sections.index');
    Route::get('/subsections', AdminSubsectionsIndex::class)->name('subsections.index');
    Route::get('/subsections/{subsection}/content', AdminSubsectionsManageContent::class)->name('subsections.content');
    Route::get('/tests', \App\Livewire\Admin\Tests\Index::class)->name('tests.index');
    
    // Маршруты для управления персоналиями
    Route::get('/figures', AdminFiguresIndex::class)->name('figures.index');
    Route::get('/figures/create', [AdminFigureController::class, 'create'])->name('figures.create');
    Route::post('/figures', [FigureController::class, 'store'])->name('figures.store');
    Route::get('/figures/{figure}/edit', [AdminFigureController::class, 'edit'])->name('figures.edit');
    Route::put('/figures/{figure}', [FigureController::class, 'update'])->name('figures.update');
    Route::delete('/figures/{figure}', [FigureController::class, 'destroy'])->name('figures.destroy');
    
    // Маршруты для управления терминами
    Route::get('/terms', AdminTermsIndex::class)->name('terms.index');
    Route::get('/terms/create', [AdminTermController::class, 'create'])->name('terms.create');
    Route::post('/terms', [TermController::class, 'store'])->name('terms.store');
    Route::get('/terms/{term}/edit', [AdminTermController::class, 'edit'])->name('terms.edit');
    Route::put('/terms/{term}', [TermController::class, 'update'])->name('terms.update');
    Route::delete('/terms/{term}', [TermController::class, 'destroy'])->name('terms.destroy');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('shablon/section', function () {
    return view('pages.shablon.section');
});

Route::get('test/figures-demo', function () {
    return view('pages.test.demo-figures');
})->name('test.figures-demo');

Route::get('test/flexible-links', function () {
    return view('pages.test.flexible-links-test');
})->name('test.flexible-links');

Route::get('test/simple', function () {
    return view('pages.test.simple-test');
})->name('test.simple');

Route::get('test/terms', function () {
    return view('pages.test.terms-test');
})->name('test.terms');

Route::get('test/links-styling', function () {
    return view('pages.test.links-styling-test');
})->name('test.links-styling');

Route::get('shablon/dictionary', function () {
    return view('pages.shablon.dictionary');
})->name('shablon.dictionary');

require __DIR__.'/auth.php';
