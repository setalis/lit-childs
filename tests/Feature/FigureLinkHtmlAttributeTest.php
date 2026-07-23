<?php

declare(strict_types=1);

use App\Models\Figure;
use App\Models\Term;
use App\Services\FigureLinkService;

beforeEach(function () {
    Figure::create([
        'first_name' => 'Олеся',
        'last_name' => 'Мамчич',
        'biography' => '<p>Біографія</p>',
    ]);

    Term::create([
        'name' => 'Метафора',
    ]);

    app(FigureLinkService::class)->refreshAll();
});

it('does not inject figure links into html attributes with processHtml', function () {
    $html = '<img alt="Олеся Мамчич" src="/portrait.jpg"> Мамчич Олеся Олександрівна';

    $processed = process_figure_links($html, true);

    expect($processed)
        ->toContain('alt="Олеся Мамчич"')
        ->not->toContain('alt="Олеся <a')
        ->toContain('class="figure-link')
        ->toContain('title="Персоналія: Олеся Мамчич"')
        ->toContain('>Мамчич</a>');
});

it('does not inject term links into html attributes with processHtml', function () {
    $html = '<img alt="Метафора" src="/term.jpg"> Метафора як троп';

    $processed = process_figure_links($html, true);

    expect($processed)
        ->toContain('alt="Метафора"')
        ->not->toContain('alt="<a')
        ->toContain('class="term-link')
        ->toContain('title="Термін: Метафора"')
        ->toContain('>Метафора</a>');
});

it('does not break title attributes when reprocessing already linked html', function () {
    $html = 'Творчість Мамчич вплинула на літературу.';

    $firstPass = process_figure_links($html, true);
    $secondPass = process_figure_links($firstPass, true);

    expect($firstPass)->toContain('title="Персоналія: Олеся Мамчич"');
    expect($secondPass)
        ->toContain('title="Персоналія: Олеся Мамчич"')
        ->not->toContain('title="Персоналія: Олеся <a')
        ->not->toContain('alt="Олеся <a');
});

it('breaks attributes when processText is used on html with names in attributes', function () {
    $html = '<img alt="Олеся Мамчич" src="/portrait.jpg"> Мамчич Олеся Олександрівна';

    $processed = process_figure_links($html, false);

    expect($processed)
        ->toContain('alt="Олеся <a')
        ->not->toContain('alt="Олеся Мамчич"');
});
