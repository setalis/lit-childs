<?php

namespace Database\Seeders;

use App\Models\Figure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateExistingFiguresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $figures = Figure::whereNull('first_name')->orWhereNull('last_name')->get();

        foreach ($figures as $figure) {
            $nameParts = explode(' ', trim($figure->name), 2);
            
            if (count($nameParts) >= 2) {
                $figure->first_name = $nameParts[0];
                $figure->last_name = $nameParts[1];
            } else {
                // Если только одно слово, считаем его фамилией
                $figure->first_name = '';
                $figure->last_name = $nameParts[0];
            }
            
            $figure->save();
        }

        $this->command->info('Обновлено ' . $figures->count() . ' персоналий с разделением имени и фамилии.');
    }
}
