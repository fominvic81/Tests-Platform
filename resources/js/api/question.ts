import { OptionByType, QuestionType } from './types';


export const QuestionTypeName: Record<QuestionType, string> = {
    [QuestionType.OneCorrect]: 'Одна правильна відповідь',
    [QuestionType.MultipleCorrect]: 'Кілька правильних відповідей',
    [QuestionType.Match]: 'Відповідність',
    [QuestionType.TextInput]: 'Введена відповідь',
    [QuestionType.Sequence]: 'Послідовність',
    [QuestionType.TextGapsTextInput]: '0',
    [QuestionType.TextGapsVariantSingleList]: '0',
    [QuestionType.TextGapsVariantMultipleLists]: '0',
}

let lastId = -1;
export const getOptionId = () => {
    return lastId--;
}

export const OptionsInitialData: {
    [T in QuestionType]: OptionByType<T>[];
} = {
    [QuestionType.OneCorrect]: [
        { id: getOptionId(), text: '', correct: false },
        { id: getOptionId(), text: '', correct: false },
    ],
    [QuestionType.MultipleCorrect]: [
        { id: getOptionId(), text: '', correct: false },
        { id: getOptionId(), text: '', correct: false },
    ],
    [QuestionType.Match]: [
        { id: getOptionId(), text: '' },
        { id: getOptionId(), text: '' },
        { id: getOptionId(), text: '', match_id: 0 },
        { id: getOptionId(), text: '', match_id: 0 },
    ],
    [QuestionType.TextInput]: [
        { id: getOptionId(), text: '' },
    ],
    [QuestionType.Sequence]: [
        { id: getOptionId(), text: '', sequence_index: 0 },
        { id: getOptionId(), text: '', sequence_index: 1 },
    ],
    [QuestionType.TextGapsTextInput]: [],
    [QuestionType.TextGapsVariantSingleList]: [],
    [QuestionType.TextGapsVariantMultipleLists]: [],
}