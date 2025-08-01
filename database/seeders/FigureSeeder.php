<?php

namespace Database\Seeders;

use App\Models\Figure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FigureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Figure::create([
            'name' => 'Тарас Шевченко',
            'biography' => 'Український поет, прозаїк, мислитель, живописець, гравер, етнограф, громадський діяч. Національний герой і символ України.',
            'image_path' => 'images/figures/shevchenko.jpg',
        ]);

        Figure::create([
            'name' => 'Іван Франко',
            'biography' => 'Український письменник, поет, публіцист, перекладач, учений, громадський і політичний діяч. Доктор філософії, дійсний член Наукового товариства імені Шевченка.',
            'image_path' => 'images/figures/franko.jpg',
        ]);

        Figure::create([
            'name' => 'Леся Українка',
            'biography' => 'Українська письменниця, перекладачка, культурна діячка. Писала в жанрах поезії, лірики, епосу, драми, прози, публіцистики.',
            'image_path' => 'images/figures/ukrainka.jpg',
        ]);
    }
}
