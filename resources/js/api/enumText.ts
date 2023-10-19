import { Accessibility, QuestionType } from './types';

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

export const AccessibilityName: Record<Accessibility, string> = {
    [Accessibility.Public]: 'Публічний',
    [Accessibility.Hidden]: 'Схований(Доступ за посиланням)',
    [Accessibility.Private]: 'Приватний',
}