import { Topic } from './topic';

export enum QuestionType {
    OneCorrect = 0,
    MultipleCorrect = 1,
    Match = 2,
    TextInput = 3,
    Sequense = 4,
    TextGapsTextInput = 5,
    TextGapsVariantSingleList = 6,
    TextGapsVariantMultipleLists = 7,
}

export type QuestionDataOneCorrect = {
    options: {
        text: string;
        image?: string;
        correct: boolean;
    }[];
}
export type QuestionDataMultipleCorrect = {
    showAmountOfCorrect: boolean;
    options: {
        text: string;
        image?: string;
        correct: boolean;
    }[];
}

export type QuestionDataMatch = {
    options: {
        text: string;
        image?: string;
    }[];
    variants: {
        text: string;
        image?: string;
    }[];
    matchTable: number[];
}

export type QuestionDataTextInput = {
    registerMatters: boolean;
    whitespaceMatters: boolean;
    options: string[];
}
export type QuestionDataSequense = {
    options: {
        text: string;
        image?: string;
        index: number;
    }[];
}
export type QuestionDataTextGapsTextInput = {

}
export type QuestionDataTextGapsVariantSingleList = {

}
export type QuestionDataTextGapsVariantMultipleLists = {

}

export type QuestionDataByType<T extends QuestionType> =
    T extends QuestionType.OneCorrect ? QuestionDataOneCorrect :
    T extends QuestionType.MultipleCorrect ? QuestionDataMultipleCorrect :
    T extends QuestionType.Match ? QuestionDataMatch :
    T extends QuestionType.TextInput ? QuestionDataTextInput :
    T extends QuestionType.Sequense ? QuestionDataSequense :
    T extends QuestionType.TextGapsTextInput ? QuestionDataTextGapsTextInput :
    T extends QuestionType.TextGapsVariantSingleList ? QuestionDataTextGapsVariantSingleList :
    T extends QuestionType.TextGapsVariantMultipleLists ? QuestionDataTextGapsVariantMultipleLists : unknown;

export interface Question<T extends QuestionType = QuestionType> {
    id: number;
    text: string;
    image?: string;
    type: T;
    data: QuestionDataByType<T>;
    topics: Topic[];
    points: number;
    explanation?: string;
}