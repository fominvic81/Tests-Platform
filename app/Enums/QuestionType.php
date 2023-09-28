<?php

namespace App\Enums;

enum QuestionType: int
{
    case OneCorrect = 0;
    case MultipleCorrectAmountHidden = 1;
    case MultipleCorrectAmountShown = 2;
    case Match = 3;
    case TextInput = 4;
    case Sequense = 5;
    case TextGapsTextInput = 6;
    case TextGapsVariantSingleList = 7;
    case TextGapsVariantMultipleLists = 8;
}