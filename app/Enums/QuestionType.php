<?php

namespace App\Enums;

enum QuestionType: int
{
    case OneCorrect = 0;
    case MultipleCorrect = 1;
    case Match = 2;
    case TextInput = 3;
    case Sequence = 4;
    case TextGapsTextInput = 5;
    case TextGapsVariantSingleList = 6;
    case TextGapsVariant = 7;
}