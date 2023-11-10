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

        User::factory(10)->
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
            ->has(Question::factory()->type(QuestionType::OneCorrect)->points(1)->text('One Correct')->data([
                'options' => [
                    ['text' => 'Incorrect 1'],
                    ['text' => 'Correct'],
                    ['text' => 'Incorrect 2'],
                    ['text' => 'Incorrect 3'],
                ],
                'answer' => [
                    'correct' => [false, true, false, false],
                ],
            ]))
            ->has(Question::factory()->type(QuestionType::MultipleCorrect)->points(1)->text('Multiple Correct')->data([
                'settings' => [
                    'showAmountOfCorrect' => false,
                ],
                'options' => [
                    ['text' => 'Incorrect 1'],
                    ['text' => 'Correct 1'],
                    ['text' => 'Incorrect 2'],
                    ['text' => 'Correct 2'],
                    ['text' => 'Incorrect 3'],
                ],
                'answer' => [
                    'correct' => [false, true, false, true, false],
                ],
            ]))
            ->has(Question::factory()->type(QuestionType::Match)->text('Match')->points(4)->data([
                'options' => [
                    ['text' => '40 + 40'],
                    ['text' => '50 - 10'],
                    ['text' => '10 * 5'],
                    ['text' => '120 / 2'],
                ],
                'variants' => [
                    ['text' => '40'],
                    ['text' => '50'],
                    ['text' => '60'],
                    ['text' => '70'],
                    ['text' => '80'],
                ],
                'answer' => [
                    'match' => [4, 0, 1, 2],
                ],
            ]))
            ->has(Question::factory()->type(QuestionType::TextInput)->points(2)->text('Text Input (Answer is abobus)')->data([
                'settings' => [
                    'registerMatters' => false,
                    'whitespaceMatters' => false,
                ],
                'answer' => [
                    'texts' => ['abobus'],
                ],
            ]))
            ->has(Question::factory()->type(QuestionType::Sequence)->points(2)->text('Sequence')->data([
                'options' => [
                    ['text' => 'First'],
                    ['text' => 'Fourth'],
                    ['text' => 'Second'],
                    ['text' => 'Third'],
                ],
                'answer' => [
                    'sequence' => [0, 2, 3, 1],
                ],
            ]))
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
