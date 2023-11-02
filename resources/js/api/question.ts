import { QuestionData, QuestionType } from './types';

export const QuestionInitialData: {
    [T in QuestionType]: QuestionData<T>;
} = {
    [QuestionType.OneCorrect]: {
        options: [
            { text: '' },
            { text: '' },
        ],
        answer: {
            correct: [false, false],
        },
    },
    [QuestionType.MultipleCorrect]: {
        settings: {
            showAmountOfCorrect: false,
        },
        options: [
            { text: '' },
            { text: '' },
        ],
        answer: {
            correct: [false, false],
        },
    },
    [QuestionType.Match]: {
        options: [
            { text: '' },
            { text: '' },
        ],
        variants: [
            { text: '' },
            { text: '' },
        ],
        answer: {
            match: [-1, -1],
        },
    },
    [QuestionType.TextInput]: {
        settings: {
            registerMatters: false,
            whitespaceMatters: false,
        },
        answer: {
            texts: [''],
        },
    },
    [QuestionType.Sequence]: {
        options: [
            { text: '' },
            { text: '' },
        ],
        answer: {
            sequence: [0, 1],
        }
    },
    [QuestionType.TextGapsTextInput]: {
        settings: {
            registerMatters: false,
            whitespaceMatters: false,
        },
        answer: {
            groups: {},
        },
    },
    [QuestionType.TextGapsVariantSingleList]: {
        options: [
            { text: '' },
            { text: '' },
        ],
        answer: {
            groups: {},
        },
    },
    [QuestionType.TextGapsVariantMultipleLists]: {
        groups: {},
        answer: {
            groups: {},
        },
    },
}