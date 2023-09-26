<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Test;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->
            has(Test::factory()->count(10))->
            has(Course::factory()->
                has(Test::factory()->count(5))->count(10)
            )->
            create();

        User::factory()->
            has(Course::factory()->state(['name' => 'ЗНО Математика'])->
                has(Test::factory()->state(['name' => 'НМТ Математика 2023']))->
                has(Test::factory()->state(['name' => 'НМТ Математика 2022']))->
                has(Test::factory()->state(['name' => 'ЗНО Математика 2021']))->
                has(Test::factory()->state(['name' => 'ЗНО Математика 2020']))
            )->
            has(Course::factory()->state(['name' => 'ЗНО Українська мова і література'])->
                has(Test::factory()->state(['name' => 'НМТ Українська мова 2023']))->
                has(Test::factory()->state(['name' => 'НМТ Українська мова 2022']))->
                has(Test::factory()->state(['name' => 'ЗНО Українська мова і література 2021']))->
                has(Test::factory()->state(['name' => 'ЗНО Українська мова і література 2020']))
            )->
            create([
                'firstname' => 'User',
                'lastname' => 'Test',
                'email' => 'test@example.com',
            ]);
    }
}
