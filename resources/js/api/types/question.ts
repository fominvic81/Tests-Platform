import { Topic } from './topic';

export type Answer<T extends QuestionType> =
    T extends QuestionType.OneCorrect ? { correct: boolean[] } :
    T extends QuestionType.MultipleCorrect ? { correct: boolean[] } :
    T extends QuestionType.Match ? { match: number[] } :
    T extends QuestionType.TextInput ? { texts: string[] } :
    T extends QuestionType.Sequence ? { sequence: number[] } :
    T extends QuestionType.TextGapsTextInput ? {
        groups: {
            texts: string[];
        }[];
    } : 
    T extends QuestionType.TextGapsVariantSingleList ? {
        groups: {
            correct: number;
        }[];
    } :
    T extends QuestionType.TextGapsVariant ? {
        groups: {
            correct: number;
        }[];
    } : {};

export interface QuestionDataTemplate {
    settings: {
        showAmountOfCorrect: boolean;
        registerMatters: boolean;
        whitespaceMatters: boolean;
    }
    groups: {
        text: string;
    }[][];
    options: {
        text: string;
        image?: string;
    }[];
    variants: {
        text: string;
        image?: string;
    }[];
    amountOfCorrect?: number;
}

type Include<T extends keyof QuestionDataTemplate, S extends keyof QuestionDataTemplate['settings'] = never> = {
    [K in T]: QuestionDataTemplate[K];
} & ([S] extends [never] ? {} : {
    settings: {
        [L in S]: QuestionDataTemplate['settings'][L];
    }
});

export type QuestionData<T extends QuestionType, A extends boolean = true> =
    { answer: A extends true ? Answer<T> : Answer<T> | null | undefined } & (
    T extends QuestionType.OneCorrect ? Include<'options'> :
    T extends QuestionType.MultipleCorrect ? Include<'options' | 'amountOfCorrect', 'showAmountOfCorrect'> :
    T extends QuestionType.Match ? Include<'options' | 'variants'> :
    T extends QuestionType.TextInput ? Include<never, 'registerMatters' | 'whitespaceMatters'> :
    T extends QuestionType.Sequence ? Include<'options'> :
    T extends QuestionType.TextGapsTextInput ? Include<never, 'registerMatters' | 'whitespaceMatters'> :
    T extends QuestionType.TextGapsVariantSingleList ? Include<'options'> :
    T extends QuestionType.TextGapsVariant ? Include<'groups'> : {});

export enum QuestionType {
    OneCorrect = 0,
    MultipleCorrect = 1,
    Match = 2,
    TextInput = 3,
    Sequence = 4,
    TextGapsTextInput = 5,
    TextGapsVariantSingleList = 6,
    TextGapsVariant = 7,
}

export interface Question<T extends QuestionType = QuestionType, A extends boolean = true> {
    id: number;
    text: string;
    image?: string;
    type: T;
    topics: Topic[];
    points: number;
    explanation?: string;
    data: QuestionData<T, A>;
}