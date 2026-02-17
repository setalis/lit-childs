<?php

declare(strict_types=1);

use App\Models\Test;
use App\Models\TestMatchPair;
use App\Models\TestQuestion;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('matching question with right image displays image in right column', function () {
    $imagePath = 'test_match_pairs/test-image.png';
    Storage::disk('public')->put($imagePath, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='));

    $test = Test::create([
        'title' => 'Test Matching With Image',
        'description' => 'Test',
        'order' => 1,
    ]);

    $question = TestQuestion::create([
        'test_id' => $test->id,
        'type' => 'matching',
        'text' => 'Match authors with works:',
        'order' => 1,
    ]);

    TestMatchPair::create([
        'question_id' => $question->id,
        'left_text' => 'Author A',
        'right_text' => 'Work 1',
        'order' => 1,
    ]);

    TestMatchPair::create([
        'question_id' => $question->id,
        'left_text' => 'Author B',
        'right_text' => null,
        'right_image_path' => $imagePath,
        'order' => 2,
    ]);

    $response = $this->get(route('test.show', $test));

    $response->assertStatus(200);
    $response->assertSee('Author A');
    $response->assertSee('Work 1');
    $response->assertSee('Author B');
    $response->assertSee('storage/'.$imagePath);
});

test('matching question with right image validates correct pairing', function () {
    $imagePath = 'test_match_pairs/test-image.png';
    Storage::disk('public')->put($imagePath, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='));

    $test = Test::create([
        'title' => 'Test Matching With Image',
        'description' => 'Test',
        'order' => 1,
    ]);

    $question = TestQuestion::create([
        'test_id' => $test->id,
        'type' => 'matching',
        'text' => 'Match:',
        'order' => 1,
    ]);

    TestMatchPair::create([
        'question_id' => $question->id,
        'left_text' => 'Left 1',
        'right_text' => 'Right Text',
        'order' => 1,
    ]);

    TestMatchPair::create([
        'question_id' => $question->id,
        'left_text' => 'Left 2',
        'right_text' => null,
        'right_image_path' => $imagePath,
        'order' => 2,
    ]);

    $response = $this->post(route('test.submit', $test), [
        '_token' => csrf_token(),
        'answers' => [
            $question->id => [
                'Left 1' => 'Right Text',
                'Left 2' => $imagePath,
            ],
        ],
    ]);

    $response->assertStatus(200);
    $response->assertViewHas('earnedPoints', 2);
    $response->assertViewHas('totalPoints', 2);
});

test('matching question with text only still works', function () {
    $test = Test::create([
        'title' => 'Test Matching Text Only',
        'description' => 'Test',
        'order' => 1,
    ]);

    $question = TestQuestion::create([
        'test_id' => $test->id,
        'type' => 'matching',
        'text' => 'Match:',
        'order' => 1,
    ]);

    TestMatchPair::create([
        'question_id' => $question->id,
        'left_text' => 'Taras Shevchenko',
        'right_text' => 'Zapovit',
        'order' => 1,
    ]);

    TestMatchPair::create([
        'question_id' => $question->id,
        'left_text' => 'Lesia Ukrainka',
        'right_text' => 'Lisova Pisnia',
        'order' => 2,
    ]);

    $response = $this->post(route('test.submit', $test), [
        '_token' => csrf_token(),
        'answers' => [
            $question->id => [
                'Taras Shevchenko' => 'Zapovit',
                'Lesia Ukrainka' => 'Lisova Pisnia',
            ],
        ],
    ]);

    $response->assertStatus(200);
    $response->assertViewHas('earnedPoints', 2);
    $response->assertViewHas('totalPoints', 2);
});
