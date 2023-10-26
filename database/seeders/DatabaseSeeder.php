<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\QuestionType;
use App\Models\Option;
use App\Models\Question;
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

        $this->call([
            GradeSeeder::class,
            SubjectSeeder::class,
        ]);

        User::factory(3)->
            has(Test::factory(10))->
            has(Course::factory(2)->sequence(['published' => true], ['published' => false])->accessibility()->
                has(Test::factory(5))
            )->
            create();

        $user = User::factory()->
            create([
                'firstname' => 'User',
                'lastname' => 'Test',
                'email' => 'test@example.com',
            ]);
        
            
        $mathCourse = Course::factory()->for($user)->published()->accessibility()->createOne(['name' => 'ЗНО Математика']);
        $mathTest2023 = Test::factory()->for($mathCourse)->published()->accessibility()
            ->has(Question::factory()->text('1 + 2 = ?')
                ->has(Option::factory()->text('1')->correct(false))
                ->has(Option::factory()->text('2')->correct(false))
                ->has(Option::factory()->text('3')->correct(true))
                ->has(Option::factory()->text('4')->correct(false))
                ->has(Option::factory()->text('5')->correct(false)))
            ->has(Question::factory()->text('2<sup>3</sup> = ?')
                ->has(Option::factory()->text('2')->correct(false))
                ->has(Option::factory()->text('4')->correct(false))
                ->has(Option::factory()->text('6')->correct(false))
                ->has(Option::factory()->text('8')->correct(false))
                ->has(Option::factory()->text('10')->correct(true)))
            ->has(Question::factory()->type(QuestionType::MultipleCorrect)->text('<p>Розв\'яжіть рівняння</p><p>x<sup>2</sup> - 4 = 0</p>')
                ->has(Option::factory()->text('-4')->correct(false))
                ->has(Option::factory()->text('-2')->correct(true))
                ->has(Option::factory()->text('0')->correct(false))
                ->has(Option::factory()->text('2')->correct(true))
                ->has(Option::factory()->text('4')->correct(false)))
            ->has(Question::factory()->type(QuestionType::Sequence)->text('Встановіть числа в порядку зростання')
                ->has(Option::factory()->text('4')->seq(4))
                ->has(Option::factory()->text('2')->seq(2))
                ->has(Option::factory()->text('1')->seq(1))
                ->has(Option::factory()->text('3')->seq(3))
                ->has(Option::factory()->text('0')->seq(0)))
            ->has(Question::factory()->type(QuestionType::TextInput)->text('3 + 2 * 3 * (4 - 2) = ?')
                ->has(Option::factory()->text('15')))
            ->has(Question::factory()->type(QuestionType::Match)->text('3 + 2 * 3 * (4 - 2)')
                ->has(Option::factory()->text('5 * 3')->match(false, 2))
                ->has(Option::factory()->text('4 * 2')->match(false, 4))
                ->has(Option::factory()->text('8 + 1')->match(false, 3))
                ->has(Option::factory()->text('4 / 2')->match(false, 1))

                ->has(Option::factory()->text('10')->match(true, 0))
                ->has(Option::factory()->text('2')->match(true, 1))
                ->has(Option::factory()->text('15')->match(true, 2))
                ->has(Option::factory()->text('9')->match(true, 3))
                ->has(Option::factory()->text('8')->match(true, 4)))
            ->create(['name' => 'НМТ Математика 2023']);

        $mathTest2022 = Test::factory()->for($mathCourse)->published()->accessibility()->create(['name' => 'НМТ Математика 2022']);
        $mathTest2021 = Test::factory()->for($mathCourse)->published()->accessibility()->create(['name' => 'ЗНО Математика 2021']);
        $mathTest2020 = Test::factory()->for($mathCourse)->published()->accessibility()->create(['name' => 'ЗНО Математика 2020']);

        $langCourse = Course::factory()->for($user)->published()->accessibility()->createOne(['name' => 'ЗНО Українська мова і література']);
        $langTest2023 = Test::factory()->for($langCourse)->published()->accessibility()->createOne(['name' => 'НМТ Українська мова 2023']);
        $langTest2022 = Test::factory()->for($langCourse)->published()->accessibility()->createOne(['name' => 'НМТ Українська мова 2022']);
        $langTest2021 = Test::factory()->for($langCourse)->published()->accessibility()->createOne(['name' => 'ЗНО Українська мова і література 2021']);
        $langTest2020 = Test::factory()->for($langCourse)->published()->accessibility()->createOne(['name' => 'ЗНО Українська мова і література 2020']);
    }
}
