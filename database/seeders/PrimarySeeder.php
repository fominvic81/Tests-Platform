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
        DB::table('roles')->insert(['name' => 'admin']);
        DB::table('roles')->insert(['name' => 'teacher']);
        DB::table('roles')->insert(['name' => 'student']);

        $admin = User::factory()->create([
            'firstname' => 'SpongeBob SquarePants',
            'lastname' => '',
            'email' => 'admin@app.com',
        ]);

        $admin->addRole('admin');
        $admin->addRole('teacher');
        $admin->addRole('student');

        $editor = User::factory()->create([
            'firstname' => 'Editor',
            'lastname' => '',
            'email' => 'editor@app.com',
        ]);

        $editor->addRole('teacher');

        $student = User::factory()->create([
            'firstname' => 'Student',
            'lastname' => '',
            'email' => 'student@app.com',
        ]);

        $student->addRole('student');

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
