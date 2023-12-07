<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PrimarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'firstname' => 'SpongeBob SquarePants',
            'lastname' => '',
            'email' => 'admin@app.com',
        ]);

        $subjects = [
            'Українська мова',
            'Математика',
            'Англійська мова',
            'Історія України',
            'Всесвітня історія',
            'Українська література',
            'Географія',
            'Фізика',
            'Біологія',
            'Хімія',
            'Німецька мова',
            'Французька мова',
            'Іспанська мова',
            'Польська мова',
            'Природознавство',
            'Інформатика',
            'Я досліджую світ',
            'Фізична культура',
            'Зарубіжна література',
            'Технології',
            'Основи здоров\'я',
            'Правознавство',
        ];
        foreach ($subjects as $subject) DB::table('subjects')->insert(['name' => $subject]);
        for ($i = 1; $i <= 12; ++$i) DB::table('grades')->insert(['name' => "$i клас"]);
    }
}
