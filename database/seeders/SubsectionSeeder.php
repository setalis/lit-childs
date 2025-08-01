<?php

namespace Database\Seeders;

use App\Models\Subsection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubsectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Предполагаем, что Section с ID=1 уже существует
        $section1Id = 1;

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.1. Художня література як вид мистецтва',
            'order' => 1,
        ]);

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.2. Дитяча література: сутність та особливості',
            'order' => 2,
        ]);

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.3. Діалектична єдність змісту і форми художнього твору',
            'order' => 3,
        ]);

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.4. Змістові компоненти та сюжетно-композиційна будова художнього твору',
            'order' => 4,
        ]);

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.5. Художні засоби літературного твору та система віршування',
            'order' => 5,
        ]);

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.6. Родово-жанровий поділ художньої літератури',
            'order' => 6,
        ]);

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.7. Аналіз художнього твору',
            'order' => 7,
        ]);

        Subsection::create([
            'section_id' => $section1Id,
            'title' => '1.8. Літературознавча пропедевтика в початкових класах',
            'order' => 8,
        ]);

        // Можно добавить подразделы для других разделов по аналогии
    }
}
