<?php

use App\Enums\QuestionType;

return [
    'type' => [
        QuestionType::OneCorrect->value => 'З однією правильною відповіддю',
        QuestionType::MultipleCorrect->value => 'З кількома правильними відповідями',
        QuestionType::Match->value => 'На встановлення відповідності',
        QuestionType::TextInput->value => 'З полем для вводу відповіді',
        QuestionType::Sequence->value => 'На встановлення послідовності',
        QuestionType::TextGapsTextInput->value => '',
        QuestionType::TextGapsVariantSingleList->value => '',
        QuestionType::TextGapsVariant->value => 'На вибір варіантів в тексті',
    ],
];