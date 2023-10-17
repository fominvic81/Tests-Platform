<?php

use App\Enums\QuestionType;

return [
    'type' => [
        QuestionType::OneCorrect->value => 'Одна правильна відповідь',
        QuestionType::MultipleCorrect->value => 'Кілька правильних відповідей',
        QuestionType::Match->value => 'Відповідність',
        QuestionType::TextInput->value => 'Введена відповідь',
        QuestionType::Sequence->value => 'Послідовність',
        QuestionType::TextGapsTextInput->value => '0',
        QuestionType::TextGapsVariantSingleList->value => '0',
        QuestionType::TextGapsVariantMultipleLists->value => '0',
    ],
];