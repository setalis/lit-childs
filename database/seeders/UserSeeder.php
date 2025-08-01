<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Администратор',
            'email' => 'slavrtm@gmail.com',
            'password' => Hash::make('77788399'),
        ]);

        $this->command->info('Создан пользователь по умолчанию: slavrtm@gmail.com');
    }
}
