import { Accessibility, QuestionType } from './types';

export const QuestionTypeName: Record<QuestionType, string> = {
    [QuestionType.OneCorrect]: 'З однією правильною відповіддю',
    [QuestionType.MultipleCorrect]: 'З кількома правильними відповідями',
    [QuestionType.Match]: 'На встановлення відповідності',
    [QuestionType.TextInput]: 'З полем для вводу відповіді',
    [QuestionType.Sequence]: 'На встановлення послідовності',
    [QuestionType.TextGapsTextInput]: '',
    [QuestionType.TextGapsVariantSingleList]: '',
    // [QuestionType.TextGapsVariant]: 'На вибір варіантів в тексті',
    [QuestionType.TextGapsVariant]: '',
}

export const AccessibilityName: Record<Accessibility, string> = {
    [Accessibility.Public]: 'Публічний',
    [Accessibility.Hidden]: 'Схований(Доступ за посиланням)',
    [Accessibility.Private]: 'Приватний',
}