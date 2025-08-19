<?php

namespace Database\Seeders;

use App\Models\Figure;
use App\Models\FigureBlock;
use Illuminate\Database\Seeder;

class FigureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем Тараса Шевченко
        $shevchenko = Figure::create([
            'first_name' => 'Тарас',
            'last_name' => 'Шевченко',
            'biography' => 'Український поет, прозаїк, мислитель, живописець, гравер, етнограф, громадський діяч. Національний герой і символ України.',
            'sources' => 'Біографічний довідник. Тарас Шевченко. Київ, 2014.',
            'image_path' => 'images/figures/shevchenko.jpg',
        ]);

        // Создаем блоки биографии для Шевченко
        FigureBlock::create([
            'figure_id' => $shevchenko->id,
            'type' => 'biography',
            'content' => 'Український поет, прозаїк, мислитель, живописець, гравер, етнограф, громадський діяч. Національний герой і символ України.',
            'order' => 1,
        ]);

        // Создаем блоки источников для Шевченко
        FigureBlock::create([
            'figure_id' => $shevchenko->id,
            'type' => 'sources',
            'content' => 'Біографічний довідник. Тарас Шевченко. Київ, 2014.',
            'order' => 1,
        ]);

        // Создаем Івана Франко
        $franko = Figure::create([
            'first_name' => 'Іван',
            'last_name' => 'Франко',
            'biography' => 'Український письменник, поет, публіцист, перекладач, учений, громадський і політичний діяч. Доктор філософії, дійсний член Наукового товариства імені Шевченка.',
            'sources' => 'Енциклопедія українознавства. Іван Франко. Львів, 1993.',
            'image_path' => 'images/figures/franko.jpg',
        ]);

        // Создаем блоки биографии для Франко
        FigureBlock::create([
            'figure_id' => $franko->id,
            'type' => 'biography',
            'content' => 'Український письменник, поет, публіцист, перекладач, учений, громадський і політичний діяч. Доктор філософії, дійсний член Наукового товариства імені Шевченка.',
            'order' => 1,
        ]);

        // Создаем блоки источников для Франко
        FigureBlock::create([
            'figure_id' => $franko->id,
            'type' => 'sources',
            'content' => 'Енциклопедія українознавства. Іван Франко. Львів, 1993.',
            'order' => 1,
        ]);

        // Создаем Лесю Українку
        $ukrainka = Figure::create([
            'first_name' => 'Леся',
            'last_name' => 'Українка',
            'biography' => 'Українська письменниця, перекладачка, культурна діячка. Писала в жанрах поезії, лірики, епосу, драми, прози, публіцистики.',
            'sources' => 'Літературна спадщина. Леся Українка. Київ, 1988.',
            'image_path' => 'images/figures/ukrainka.jpg',
        ]);

        // Создаем блоки биографии для Українки
        FigureBlock::create([
            'figure_id' => $ukrainka->id,
            'type' => 'biography',
            'content' => 'Українська письменниця, перекладачка, культурна діячка. Писала в жанрах поезії, лірики, епосу, драми, прози, публіцистики.',
            'order' => 1,
        ]);

        // Создаем блоки источников для Українки
        FigureBlock::create([
            'figure_id' => $ukrainka->id,
            'type' => 'sources',
            'content' => 'Літературна спадщина. Леся Українка. Київ, 1988.',
            'order' => 1,
        ]);
    }
}
