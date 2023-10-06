import { OptionByType } from './option';
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

export interface Question<T extends QuestionType = QuestionType> {
    id: number;
    text: string;
    image?: string;
    type: T;
    options: OptionByType<T>[];
    topics: Topic[];
    points: number;
    explanation?: string;
    register_matters: boolean;
    whitespace_matters: boolean;
    show_amount_of_correct: boolean;
}