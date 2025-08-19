<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Сначала создаем базовые структуры
        $this->call([
            UserSeeder::class,
            SectionSeeder::class,
            SubsectionSeeder::class,
        ]);

        // Затем создаем контент
        $this->call([
            TermSeeder::class,
            FigureSeeder::class,
            ContentBlockSeeder::class,
            TestSeeder::class,
        ]);

        // В конце создаем тестовые данные
        $this->call([
            ControlBlockTestSeeder::class,
            TestFigureSeeder::class,
        ]);
    }
}
