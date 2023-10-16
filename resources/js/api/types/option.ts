import { QuestionType } from './question';

type Option = {
    id: number;
    text: string;
}

type OptionOneCorrect = {
    image?: string;
    correct: boolean;
}

type OptionMultipleCorrect = {
    image?: string;
    correct: boolean;
}

type OptionMatch = {
    image?: string;
    match_id?: number;
}

type OptionTextInput = {
}

type OptionSequence = {
    image?: string;
    sequence_index: number;
}
type OptionTextGapsTextInput = {

}
type OptionTextGapsVariantSingleList = {

}
type OptionTextGapsVariantMultipleLists = {

}

export type OptionByType<T extends QuestionType> = Option & (
    T extends QuestionType.OneCorrect ? OptionOneCorrect :
    T extends QuestionType.MultipleCorrect ? OptionMultipleCorrect :
    T extends QuestionType.Match ? OptionMatch :
    T extends QuestionType.TextInput ? OptionTextInput :
    T extends QuestionType.Sequence ? OptionSequence :
    T extends QuestionType.TextGapsTextInput ? OptionTextGapsTextInput :
    T extends QuestionType.TextGapsVariantSingleList ? OptionTextGapsVariantSingleList :
    T extends QuestionType.TextGapsVariantMultipleLists ? OptionTextGapsVariantMultipleLists : {});