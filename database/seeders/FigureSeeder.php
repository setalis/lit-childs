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
            'first_name' => 'Тарас',
            'last_name' => 'Шевченко',
            'biography' => 'Український поет, прозаїк, мислитель, живописець, гравер, етнограф, громадський діяч. Національний герой і символ України.',
            'sources' => 'Біографічний довідник. Тарас Шевченко. Київ, 2014.',
            'image_path' => 'images/figures/shevchenko.jpg',
        ]);

        Figure::create([
            'first_name' => 'Іван',
            'last_name' => 'Франко',
            'biography' => 'Український письменник, поет, публіцист, перекладач, учений, громадський і політичний діяч. Доктор філософії, дійсний член Наукового товариства імені Шевченка.',
            'sources' => 'Енциклопедія українознавства. Іван Франко. Львів, 1993.',
            'image_path' => 'images/figures/franko.jpg',
        ]);

        Figure::create([
            'first_name' => 'Леся',
            'last_name' => 'Українка',
            'biography' => 'Українська письменниця, перекладачка, культурна діячка. Писала в жанрах поезії, лірики, епосу, драми, прози, публіцистики.',
            'sources' => 'Літературна спадщина. Леся Українка. Київ, 1988.',
            'image_path' => 'images/figures/ukrainka.jpg',
        ]);
    }
}
