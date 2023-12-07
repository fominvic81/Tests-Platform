<?php

namespace Database\Seeders;

use App\Enums\QuestionType;
use App\Models\Course;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->
            has(Test::factory(10))->
            has(Course::factory(2)->sequence(['published' => true], ['published' => false])->accessibility()->
                has(Test::factory(5))
            )->
            create();

        $mathTest2023 = Test::factory()->published()->accessibility()
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
            ->has(Question::factory()->type(QuestionType::TextInput)->points(2)->text('Text Input (Answer is testify)')->data([
                'settings' => [
                    'registerMatters' => false,
                    'whitespaceMatters' => false,
                ],
                'answer' => [
                    'texts' => ['testify'],
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
            ->create(['user_id' => 1, 'name' => 'Test for testing']);
    }
}
