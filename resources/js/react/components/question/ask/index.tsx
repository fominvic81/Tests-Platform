import React from 'react';
import { Answer, Question, QuestionType, imagePath } from '../../../../api';
import { Sequence } from './Sequence';
import { TextInput } from './TextInput';
import { Match } from './Match';
import { MultipleCorrect } from './MultipleCorrect';
import { OneCorrect } from './OneCorrect';
import { ImageContain } from '../../common/ImageContain';

const questionComponentByType: Record<QuestionType, React.FC<any>> = {
    [QuestionType.OneCorrect]: OneCorrect,
    [QuestionType.MultipleCorrect]: MultipleCorrect,
    [QuestionType.Match]: Match,
    [QuestionType.TextInput]: TextInput,
    [QuestionType.Sequence]: Sequence,
    [QuestionType.TextGapsTextInput]: () => <></>,
    [QuestionType.TextGapsVariantSingleList]: () => <></>,
    [QuestionType.TextGapsVariant]: () => <></>,
} as const;

interface Props {
    question: Question<QuestionType, false>;
}

export const QuestionAsk: React.FC<Props> = ({ question }) => {

    const Component = questionComponentByType[question.type];

    return <div>
        <div className='flex'>
            {question.image && <ImageContain src={ imagePath(question.image) }></ImageContain>}
            <div dangerouslySetInnerHTML={{ __html: question.text }}></div>
        </div>
        <Component question={ question }></Component>
    </div>
}