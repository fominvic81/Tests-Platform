import { QuestionDataByType, QuestionType } from './types';


export const QuestionTypeName: Record<QuestionType, string> = {
    [QuestionType.OneCorrect]: 'Одна правильна відповідь',
    [QuestionType.MultipleCorrect]: 'Кілька правильних відповідей',
    [QuestionType.Match]: 'Відповідність',
    [QuestionType.TextInput]: 'Введена відповідь',
    [QuestionType.Sequense]: 'Послідовність',
    [QuestionType.TextGapsTextInput]: '0',
    [QuestionType.TextGapsVariantSingleList]: '0',
    [QuestionType.TextGapsVariantMultipleLists]: '0',
}

export const QuestionTypeInitialData: {
    [T in QuestionType]: QuestionDataByType<T>;
} = {
    [QuestionType.OneCorrect]: {
        options: [
            { text: '', correct: false },
            { text: '', correct: false }
        ],
    },
    [QuestionType.MultipleCorrect]: {
        showAmountOfCorrect: false,
        options: [
            { text: '', correct: false },
            { text: '', correct: false }
        ],
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
        matchTable: [],
    },
    [QuestionType.TextInput]: {
        whitespaceMatters: false,
        registerMatters: false,
        options: [],
    },
    [QuestionType.Sequense]: {
        options: [
            { text: '', index: 0 },
            { text: '', index: 0 },
        ],
    },
    [QuestionType.TextGapsTextInput]: {},
    [QuestionType.TextGapsVariantSingleList]: {},
    [QuestionType.TextGapsVariantMultipleLists]: {},
}