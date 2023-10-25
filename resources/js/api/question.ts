import { OptionByType, QuestionType } from './types';

let lastId = -1;
let lastMatchId = 1;
export const getOptionId = () => lastId--;
export const getVariantId = () => lastMatchId++;

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
        { id: getOptionId(), text: '', option_id: getVariantId() },
        { id: getOptionId(), text: '', option_id: getVariantId() },
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