import { OptionByType, QuestionType } from './types';


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

export const OptionInitialData: {
    [T in QuestionType]: OptionByType<T>[];
} = {
    [QuestionType.OneCorrect]: [
        { text: '', correct: false },
        { text: '', correct: false }
    ],
    [QuestionType.MultipleCorrect]: [
        { text: '', correct: false },
        { text: '', correct: false }
    ],
    [QuestionType.Match]: [
        { text: '' },
        { text: '' },
        { text: '', match_id: 0 },
        { text: '', match_id: 1 },
    ],
    [QuestionType.TextInput]: [
        { text: '' },
    ],
    [QuestionType.Sequense]: [
        { text: '', seq_index: 0 },
        { text: '', seq_index: 0 },
    ],
    [QuestionType.TextGapsTextInput]: [],
    [QuestionType.TextGapsVariantSingleList]: [],
    [QuestionType.TextGapsVariantMultipleLists]: [],
}