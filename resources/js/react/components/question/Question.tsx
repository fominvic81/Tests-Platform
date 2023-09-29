import React from 'react';
import { Question, QuestionType } from '../../../api';
import { QuestionOneCorrect } from './OneCorrect';

const questionComponentByType: Record<QuestionType, React.FC<any>> = {
    [QuestionType.OneCorrect]: QuestionOneCorrect,
    [QuestionType.MultipleCorrectAmountHidden]: () => <></>,
    [QuestionType.MultipleCorrectAmountShown]: () => <></>,
    [QuestionType.Match]: () => <></>,
    [QuestionType.TextInput]: () => <></>,
    [QuestionType.Sequense]: () => <></>,
    [QuestionType.TextGapsTextInput]: () => <></>,
    [QuestionType.TextGapsVariantSingleList]: () => <></>,
    [QuestionType.TextGapsVariantMultipleLists]: () => <></>,
} as const;

interface Props {
    question: Question;
    index: number;
}

export const QuestionComponent: React.FC<Props> = ({ question, index }) => {

    const Component = questionComponentByType[question.type];
    // console.log(component);

    return <div className='bg-white p-3 my-4 shadow'>
        { index + 1 }
        <div className='text-lg indent-2'>{ question.text }</div>
        <hr className='my-3' />
        <Component question={question}></Component>
    </div>
}