import { QuestionType } from './question';



export type OptionOneCorrect = {
    text: string;
    image?: string;
    correct: boolean;
}

export type OptionMultipleCorrect = {
    text: string;
    image?: string;
    correct: boolean;
}

export type OptionMatch = {
    text: string;
    image?: string;
    match_id?: number;
}

export type OptionTextInput = {
    text: string;
}

export type OptionSequense = {
    text: string;
    image?: string;
    seq_index: number;
}
export type OptionTextGapsTextInput = {

}
export type OptionTextGapsVariantSingleList = {

}
export type OptionTextGapsVariantMultipleLists = {

}

export type OptionByType<T extends QuestionType> =
    T extends QuestionType.OneCorrect ? OptionOneCorrect :
    T extends QuestionType.MultipleCorrect ? OptionMultipleCorrect :
    T extends QuestionType.Match ? OptionMatch :
    T extends QuestionType.TextInput ? OptionTextInput :
    T extends QuestionType.Sequense ? OptionSequense :
    T extends QuestionType.TextGapsTextInput ? OptionTextGapsTextInput :
    T extends QuestionType.TextGapsVariantSingleList ? OptionTextGapsVariantSingleList :
    T extends QuestionType.TextGapsVariantMultipleLists ? OptionTextGapsVariantMultipleLists : unknown;