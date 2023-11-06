<?php

namespace App\Helpers;
use App\Enums\QuestionType;

class AnswerChecker {

    public static function checkOneCorrect(array $userAnswer, array $question): float
    {
        if ($question['answer']['correct'] === $userAnswer['correct']) return 1;
        return 0;
    }

    public static function checkMultipleCorrect(array $userAnswer, array $question): float
    {
        $answer = $question['answer']['correct'];
        if (count($answer) !== count($userAnswer['correct'])) return 0;

        $maxCorrect = 0;
        $correct = 0;

        // TODO
        foreach ($userAnswer['correct'] as $key => $value) {
            if ($answer[$key]) ++$maxCorrect;
            if ($value && $answer[$key]) {
                ++$correct;
            } else if ($value !== $answer[$key]) {
                --$correct;
            }
        }

        return max(0, $correct / $maxCorrect);
    }

    public static function checkMatch(array $userAnswer, array $question): float
    {
        $match = $question['answer']['match'];
        if (count($match) !== count($userAnswer['match'])) return 0;
        
        $correct = 0;

        foreach ($userAnswer['match'] as $key => $value) {
            if ($value === $match[$key]) ++$correct;
        }

        return $correct / count($match);
    }

    private static function transformText(string $text, array $settings): string
    {
        $text = trim($text);
        if (!$settings['registerMatters']) $text = mb_strtolower($text);
        if (!$settings['whitespaceMatters']) $text = str_replace(' ', '', $text);
        return $text;
    }

    public static function checkTextInput(array $userAnswer, array $question): float
    {
        $text = AnswerChecker::transformText($userAnswer['texts'][0] ?? '', $question['settings']);

        foreach ($question['answer']['texts'] as $variant) {
            if ($text === AnswerChecker::transformText($variant, $question['settings'])) return 1;
        }
        return 0;
    }

    public static function checkSequence(array $userAnswer, array $question): float
    {
        $sequence = $userAnswer['sequence'];
        $correctSequence = $question['answer']['sequence'];
        $size = count($correctSequence);
        if (count($sequence) !== $size) return 0;

        $transformed = [];
        foreach ($sequence as $value) {
            array_push($transformed, array_search($value, $correctSequence));
        }

        $inversions = 0;
        for ($i = 0; $i < $size; ++$i) {

            for ($j = 0; $j < $i; ++$j) {
                if ($transformed[$j] > $transformed[$i]) {
                    ++$inversions;
                }
            }
        }

        $maxInversions = $size * ($size - 1) / 2;
        return pow(1 - $inversions / $maxInversions, 2);
    }

    public static function check(QuestionType $type, array $userAnswer, array $question): float
    {
        switch ($type) {
            case QuestionType::OneCorrect: return AnswerChecker::checkOneCorrect($userAnswer, $question);
            case QuestionType::MultipleCorrect: return AnswerChecker::checkMultipleCorrect($userAnswer, $question);
            case QuestionType::Match: return AnswerChecker::checkMatch($userAnswer, $question);
            case QuestionType::TextInput: return AnswerChecker::checkTextInput($userAnswer, $question);
            case QuestionType::Sequence: return AnswerChecker::checkSequence($userAnswer, $question);
            default: return 0;
        }
    }

}