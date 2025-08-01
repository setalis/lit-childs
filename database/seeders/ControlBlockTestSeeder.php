<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ControlBlock;
use App\Models\Test;
use App\Models\Subsection;

class ControlBlockTestSeeder extends Seeder
{
    public function run(): void
    {
        $subsection = Subsection::first();
        $test1 = Test::where('title', 'like', '%літератури%')->first();
        $test2 = Test::where('title', 'like', '%математики%')->first();

        if ($subsection && $test1) {
            ControlBlock::create([
                'subsection_id' => $subsection->id,
                'test_id' => $test1->id,
                'order' => 1
            ]);
        }

        if ($subsection && $test2) {
            ControlBlock::create([
                'subsection_id' => $subsection->id,
                'test_id' => $test2->id,
                'order' => 2
            ]);
        }
    }
} 