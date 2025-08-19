<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Проверяем, существует ли уже пользователь с таким email
        if (! User::where('email', 'slavrtm@gmail.com')->exists()) {
            User::create([
                'name' => 'Администратор',
                'email' => 'slavrtm@gmail.com',
                'password' => Hash::make('77788399'),
            ]);

            $this->command->info('Создан пользователь по умолчанию: slavrtm@gmail.com');
        } else {
            $this->command->info('Пользователь slavrtm@gmail.com уже существует, пропускаем создание.');
        }
    }
}
