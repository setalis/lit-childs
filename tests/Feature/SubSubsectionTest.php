<?php

declare(strict_types=1);

use App\Livewire\Admin\Subsections\Index;
use App\Models\Section;
use App\Models\Subsection;
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ── Допоміжні функції ──────────────────────────────────────────────────────

function makeSection(): Section
{
    return Section::factory()->create(['order' => 1]);
}

function makeSubsection(Section $section, int $order = 1): Subsection
{
    return Subsection::factory()->create([
        'section_id' => $section->id,
        'parent_id' => null,
        'order' => $order,
    ]);
}

function makeSubSubsection(Subsection $parent, int $order = 1): Subsection
{
    return Subsection::factory()->create([
        'section_id' => $parent->section_id,
        'parent_id' => $parent->id,
        'order' => $order,
    ]);
}

function authUser(): User
{
    return User::factory()->create();
}

// ── Модель ─────────────────────────────────────────────────────────────────

it('subsection has subSubsections relationship', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    expect($parent->subSubsections)->toHaveCount(1)
        ->and($parent->subSubsections->first()->id)->toBe($child->id);
});

it('sub-subsection has parent relationship', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    expect($child->parent->id)->toBe($parent->id);
});

it('sub-subsection inherits section_id from parent', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    expect($child->section_id)->toBe($section->id);
});

it('Section subsections() only returns top-level subsections', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    makeSubSubsection($parent);

    expect($section->subsections)->toHaveCount(1)
        ->and($section->subsections->first()->id)->toBe($parent->id);
});

it('deleting parent subsection nullifies child parent_id via nullOnDelete', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    $parent->delete();

    expect(Subsection::find($child->id)->parent_id)->toBeNull();
});

// ── Admin CRUD (Livewire) ──────────────────────────────────────────────────

it('admin can create a top-level subsection', function () {
    $user = authUser();
    $section = makeSection();

    Livewire::actingAs($user)
        ->test(Index::class)
        ->call('openCreateModal')
        ->set('subsectionTitle', 'Новий підрозділ')
        ->set('subsectionOrder', 2)
        ->set('selectedSectionId', $section->id)
        ->call('saveSubsection')
        ->assertHasNoErrors();

    expect(Subsection::where('title', 'Новий підрозділ')->whereNull('parent_id')->exists())->toBeTrue();
});

it('admin can create a sub-subsection via openCreateSubSubsectionModal', function () {
    $user = authUser();
    $section = makeSection();
    $parent = makeSubsection($section);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->call('openCreateSubSubsectionModal', $parent->id)
        ->set('subsectionTitle', 'Під-підрозділ')
        ->set('subsectionOrder', 1)
        ->call('saveSubsection')
        ->assertHasNoErrors();

    $child = Subsection::where('title', 'Під-підрозділ')->first();

    expect($child)->not->toBeNull()
        ->and($child->parent_id)->toBe($parent->id)
        ->and($child->section_id)->toBe($section->id);
});

it('sub-subsection creation requires parentSubsectionId to exist', function () {
    $user = authUser();

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('parentSubsectionId', 99999)
        ->set('subsectionTitle', 'Test')
        ->set('subsectionOrder', 1)
        ->call('saveSubsection')
        ->assertHasErrors(['parentSubsectionId']);
});

it('admin can edit a sub-subsection', function () {
    $user = authUser();
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->call('openEditModal', $child->id)
        ->assertSet('parentSubsectionId', $parent->id)
        ->set('subsectionTitle', 'Оновлена назва')
        ->call('saveSubsection')
        ->assertHasNoErrors();

    expect($child->fresh()->title)->toBe('Оновлена назва');
});

it('admin can delete a sub-subsection', function () {
    $user = authUser();
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->call('openDeleteModal', $child->id)
        ->call('deleteSubsection');

    expect(Subsection::find($child->id))->toBeNull();
});

it('admin subsections index shows sub-subsections nested under parent', function () {
    $user = authUser();
    $section = makeSection();
    $parent = makeSubsection($section, 1);
    $child = makeSubSubsection($parent, 1);

    Livewire::actingAs($user)
        ->test(Index::class)
        ->assertSee($parent->title)
        ->assertSee($child->title);
});

// ── Публічні маршрути ──────────────────────────────────────────────────────

it('public subsection page shows sub-subsection cards when they exist', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    $response = $this->get(route('subsections.show', $parent));

    $response->assertOk()
        ->assertSee($child->title)
        ->assertSee('Під-підрозділи');
});

it('public subsection page shows content blocks when no sub-subsections exist', function () {
    $section = makeSection();
    $subsection = makeSubsection($section);

    $response = $this->get(route('subsections.show', $subsection));

    $response->assertOk()
        ->assertSee('Теоретичний матеріал')
        ->assertSee('Практичні завдання');
});

it('public sub-subsection page has correct breadcrumbs', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    $response = $this->get(route('subsections.show', $child));

    $response->assertOk()
        ->assertSee($parent->title)
        ->assertSee($section->title);
});

it('section show page renders with sub-subsections', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    makeSubSubsection($parent);

    $response = $this->get(route('sections.show', $section));

    $response->assertOk()
        ->assertSee($parent->title);
});

it('sections index accordion renders with sub-subsections', function () {
    $section = makeSection();
    $parent = makeSubsection($section);
    $child = makeSubSubsection($parent);

    $response = $this->get(route('sections.index'));

    $response->assertOk()
        ->assertSee($parent->title)
        ->assertSee($child->title);
});
