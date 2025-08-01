<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Term::create([
            'name' => 'Алегорія',
            'definition' => 'Спосіб двопланового художнього зображення, що грунтується на приховуванні реальних осіб, явищ і предметів під конкретними художніми образами з відповідними асоціаціями, з характерними рисами приховуваного.',
            'image_path' => 'images/terms/allegory.jpg', // Пример пути
        ]);

        Term::create([
            'name' => 'Балада',
            'definition' => 'Жанр ліро-епічної поезії фантастичного, історико-героїчного або соціально-побутового характеру з драматичним сюжетом.',
            'image_path' => 'images/terms/ballad.jpg',
        ]);

        Term::create([
            'name' => 'Версифікація',
            'definition' => 'Система організації поетичного мовлення, в основі якої лежить закономірне ритмічне чергування певних мовних одиниць; віршування.',
        ]);

        Term::create([
            'name' => 'Гіпербола',
            'definition' => 'Стилістична фігура явного і навмисного перебільшення для посилення виразності та підкреслення сказаної думки.',
            'image_path' => 'images/terms/hyperbole.png',
        ]);
    }
}
