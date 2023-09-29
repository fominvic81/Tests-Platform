import { Topic } from './topic';

export enum QuestionType {
    OneCorrect = 0,
    MultipleCorrectAmountHidden = 1,
    MultipleCorrectAmountShown = 2,
    Match = 3,
    TextInput = 4,
    Sequense = 5,
    TextGapsTextInput = 6,
    TextGapsVariantSingleList = 7,
    TextGapsVariantMultipleLists = 8,
}

export type QuestionDataOneCorrect = {
    options: {
        text: string;
        image?: string;
        correct: boolean;
    }[];
}
export type QuestionDataMultipleCorrectAmountHidden = QuestionDataOneCorrect;
export type QuestionDataMultipleCorrectAmountShown = QuestionDataOneCorrect;

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
    options: string[];
}
export type QuestionDataSequense = {
    options: {
        text: string;
        image?: string;
        index: number;
    }
}
export type QuestionDataTextGapsTextInput = {

}
export type QuestionDataTextGapsVariantSingleList = {

}
export type QuestionDataTextGapsVariantMultipleLists = {

}

type QuestionDataByType<T extends QuestionType> =
    T extends QuestionType.OneCorrect ? QuestionDataOneCorrect :
    T extends QuestionType.MultipleCorrectAmountHidden ? QuestionDataMultipleCorrectAmountHidden :
    T extends QuestionType.MultipleCorrectAmountShown ? QuestionDataMultipleCorrectAmountShown :
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