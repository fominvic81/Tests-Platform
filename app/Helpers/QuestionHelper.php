<?php

namespace App\Helpers;
use App\Enums\QuestionType;
use App\Helpers\ImageHelper;
use App\Rules\AnswerData;

class QuestionHelper {

    private static $rules = [
        'settings' => [
            // 'settings' => ['required', 'array:showAmountOfCorrect,registerMatters,whitespaceMatters'],
            'showAmountOfCorrect' => [
                'settings.showAmountOfCorrect' => ['required', 'boolean'],
            ],
            'registerMatters' => [
                'settings.registerMatters' => ['required', 'boolean'],
            ],
            'whitespaceMatters' => [
                'settings.whitespaceMatters' => ['required', 'boolean'],
            ],
        ],

        'options' => [
            'options' => ['required', 'array', 'min:2', 'max:50'],
            'optoins.*' => ['required', 'array:text,image,del_image'],
            'options.*.text' => ['required', 'string', 'distinct'],
            'options.*.image' => ['nullable', 'image', 'max:10240'],
            'options.*.del_image' => ['nullable', 'boolean']
        ],

        'variants' => [
            'variants' => ['required', 'array', 'min:2', 'max:50'],
            'variants.*' => ['required', 'array:text,image,del_image'],
            'variants.*.text' => ['required', 'string', 'distinct'],
            'variants.*.image' => ['nullable', 'image', 'max:10240'],
            'options.*.del_image' => ['nullable', 'boolean']
        ],

        'groups' => [
            'groups' => ['required', 'array', 'min:1', 'max:20'],
            'groups.*' => ['required', 'array', 'min:2', 'max:20'],
            'groups.*.*' => ['required', 'array:text'],
            'groups.*.*.text' => ['required', 'string'],
        ],
    ];

    private static $answerRules = [
        // ['required', 'array:correct,match,sequence,texts,groups'],

        'correct' => [
            'correct' => ['required', 'array', 'min:2', 'max:50'],
            'correct.*' => ['required', 'boolean'],
        ],

        'match' => [
            'match' => ['required', 'array', 'min:2', 'max:50'],
            'match.*' => ['required', 'integer'],
        ],

        'sequence' => [
            'sequence' => ['required', 'array', 'min:2', 'max:50'],
            'sequence.*' => ['required', 'integer'],
        ],

        'texts' => [
            'texts' => ['required', 'array', 'min:1', 'max:50'],
            'texts.*' => ['required', 'string'],
        ],

        'groups' => [
            // 'groups' => ['required', 'array', 'min:1', 'max:20'],
            // 'groups.*' => ['required', 'array:correct,texts'],

            'correct' => [
                'groups.*.correct' => ['required', 'array', 'min:2', 'max:50'],
                'groups.*.correct.*' => ['required', 'boolean'],
            ],

            'texts' => [
                'groups.*.texts' => ['required', 'array', 'min:1', 'max:50'],
                'groups.*.texts.*' => ['required', 'string'],
            ],
        ],
    ];

    public static function getRulesByType(QuestionType $type)
    {
        return [
            ...[
                QuestionType::OneCorrect->value => [
                    ...QuestionHelper::$rules['options'],
                ],
                QuestionType::MultipleCorrect->value => [
                    ...QuestionHelper::$rules['settings']['showAmountOfCorrect'],
                    ...QuestionHelper::$rules['options'],
                ],
                QuestionType::Match->value => [
                    ...QuestionHelper::$rules['options'],
                    ...QuestionHelper::$rules['variants'],
                ],
                QuestionType::TextInput->value => [
                    ...QuestionHelper::$rules['settings']['registerMatters'],
                    ...QuestionHelper::$rules['settings']['whitespaceMatters'],
                ],
                QuestionType::Sequence->value => [
                    ...QuestionHelper::$rules['options'],
                ],
                QuestionType::TextGapsTextInput->value => [
                    ...QuestionHelper::$rules['settings']['registerMatters'],
                    ...QuestionHelper::$rules['settings']['whitespaceMatters'],
                ],
                QuestionType::TextGapsVariantSingleList->value => [
                    ...QuestionHelper::$rules['options'],
                ],
                QuestionType::TextGapsVariantMultipleLists->value => [
                    ...QuestionHelper::$rules['groups'],
                ],
            ][$type->value],
            'answer' => ['required', new AnswerData($type)],
        ];
    }

    public static function getAnswerRulesByType(QuestionType $type): array
    {
        return [
            QuestionType::OneCorrect->value => [
                ...QuestionHelper::$answerRules['correct'],
            ],
            QuestionType::MultipleCorrect->value => [
                ...QuestionHelper::$answerRules['correct'],
            ],
            QuestionType::Match->value => [
                ...QuestionHelper::$answerRules['match'],
            ],
            QuestionType::TextInput->value => [
                ...QuestionHelper::$answerRules['texts'],
            ],
            QuestionType::Sequence->value => [
                ...QuestionHelper::$answerRules['sequence'],
            ],
            QuestionType::TextGapsTextInput->value => [
                ...QuestionHelper::$answerRules['groups']['texts'],
            ],
            QuestionType::TextGapsVariantSingleList->value => [
                ...QuestionHelper::$answerRules['groups']['correct'],
            ],
            QuestionType::TextGapsVariantMultipleLists->value => [
                ...QuestionHelper::$answerRules['groups']['correct'],
            ],
        ][$type->value];
    }

    public static function parse(array $json, array $old = null): array
    {
        $data = [];
        if (isset($json['settings'])) {
            $settings = [];
            if (isset($json['settings']['showAmountOfCorrect'])) $settings['showAmountOfCorrect'] = boolval($json['settings']['showAmountOfCorrect']);
            if (isset($json['settings']['registerMatters'])) $settings['registerMatters'] = boolval($json['settings']['registerMatters']);
            if (isset($json['settings']['whitespaceMatters'])) $settings['whitespaceMatters'] = boolval($json['settings']['whitespaceMatters']);

            $data['settings'] = $settings;
        }
        if (isset($json['groups'])) {
            $groups = [];

            foreach ($json['groups'] as $groupName => $jsonGroup) {
                $group = [];

                foreach ($jsonGroup as $value) {
                    array_push($group, [
                        'text' => clean($value['text']),
                    ]);
                }

                $groups[$groupName] = $group;
            }

            $data['groups'] = $groups;
        }
        
        foreach (['options', 'variants'] as $field) {
            if (isset($json[$field])) {
                $values = [];
    
                foreach ($json[$field] as $key => $value) {
    
                    $deleteImage = boolval($value['del_image'] ?? null);
                    $imagePath = isset($value['image']) ? ImageHelper::uploadImage($value['image']) :
                        ($deleteImage ? null : ($old[$field][$key]['image'] ?? null));
    
                    array_push($values, [
                        'text' => clean($value['text']),
                        'image' => $imagePath,
                    ]);
                }
    
                $data[$field] = $values;
            }
        }

        $data['answer'] = QuestionHelper::parseAnswer($json['answer']);

        return $data;
    }

    public static function parseAnswer(array $json): array
    {
        $data = [];
        if (isset($json['correct'])) {
            $correct = [];

            foreach ($json['correct'] as $isCorrect) {
                array_push($correct, boolval($isCorrect));
            }

            $data['correct'] = $correct;
        }

        foreach (['match', 'sequence'] as $field) {
            if (isset($json[$field])) {
                $values = [];
    
                foreach ($json[$field] as $value) {
                    array_push($values, intval($value));
                }

                $data[$field] = $values;
            }
        }

        if (isset($json['texts'])) {
            $texts = [];

            foreach ($json['texts'] as $text) {
                array_push($texts, clean($text));
            }

            $data['texts'] = $texts;
        }

        if (isset($json['groups'])) {
            $groups = [];

            foreach ($json['groups'] as $groupName => $jsonGroup) {
                $group = [];

                if (isset($jsonGroup['texts'])) {
                    $texts = [];
                    foreach ($jsonGroup['texts'] as $text) {
                        array_push($texts, clean($text));
                    }
                    $group['texts'] = $texts;
                }

                if (isset($jsonGroup['correct'])) {
                    $correct = [];

                    foreach ($jsonGroup['correct'] as $correct) {
                        array_push($correct, boolval($correct));

                    }
                    $group['correct'] = $correct;
                }

                $groups[$groupName] = $group;
            }

            $data['groups'] = $groups;
        }

        return $data;
    }
}