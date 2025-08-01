<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'title' => 'РОЗДІЛ 1. ЛІТЕРАТУРОЗНАВЧІ ЗАСАДИ МЕТОДИКИ НАВЧАННЯ ЧИТАННЯ В ПОЧАТКОВІЙ ШКОЛІ',
            'description' => 'Опис для розділу 1',
            'order' => 1,
        ]);

        Section::create([
            'title' => 'РОЗДІЛ 2. ПСИХОЛОГО-ПЕДАГОГІЧНІ ЗАСАДИ НАВЧАННЯ ЧИТАННЯ МОЛОДШИХ ШКОЛЯРІВ',
            'description' => 'Опис для розділу 2',
            'order' => 2,
        ]);

        Section::create([
            'title' => 'РОЗДІЛ 3. МЕТОДИКА РОБОТИ НАД ТЕКСТОМ ХУДОЖНЬОГО ТВОРУ В 1-4 КЛАСАХ',
            'description' => 'Опис для розділу 3',
            'order' => 3,
        ]);
    }
}
