import React from 'react';
import { Question, QuestionType } from '../../../api';
import { storagePath } from '../../../api/storagePath';
import { OneCorrect } from './OneCorrect';
import { MultipleCorrect } from './MultipleCorrect';
import { TextInput } from './TextInput';
import { Match } from './Match';
import { ImageContain } from './ImageContain';
import { Sequence } from './Sequence';

const questionComponentByType: Record<QuestionType, React.FC<any>> = {
    [QuestionType.OneCorrect]: OneCorrect,
    [QuestionType.MultipleCorrect]: MultipleCorrect,
    [QuestionType.Match]: Match,
    [QuestionType.TextInput]: TextInput,
    [QuestionType.Sequence]: Sequence,
    [QuestionType.TextGapsTextInput]: () => <></>,
    [QuestionType.TextGapsVariantSingleList]: () => <></>,
    [QuestionType.TextGapsVariantMultipleLists]: () => <></>,
} as const;

interface Props {
    question: Question;
    index: number;
    onDelete?: () => any;
    onEdit?:() => any;
}

export const QuestionComponent: React.FC<Props> = ({ question, index, onDelete, onEdit }) => {

    const Component = questionComponentByType[question.type];
    
    return <div className='bg-white p-3 my-4 shadow'>
        <div>
            <div className='flex justify-between items-center'>
                <div className='bg-gray-200 border border-gray-300 px-2 rounded mr-2 font-mono'>Завдання №{ index + 1 }</div>
                <div>
                    <button
                        type='button'
                        className='inline mx-2 p-1 bg-sky-500 hover:bg-sky-600 border border-gray-500 rounded'
                        onClick={onEdit}
                    >Редагувати</button>    
                    <button
                        type='button'
                        className='inline mx-2 p-1 bg-sky-500 hover:bg-sky-600 border border-gray-500 rounded'
                        onClick={onDelete}
                    >Видалити</button>
                </div>
            </div>
            <div className='grid grid-cols-[auto_1fr]'>
                {question.image && <ImageContain src={ storagePath(question.image) }></ImageContain>}
                <div
                    className='ml-3 mt-1'
                    dangerouslySetInnerHTML={{ __html: question.text }}
                ></div>
            </div>
            <hr className='my-3' />
            <Component options={ question.options }></Component>
            {/* @if ($question->type === App\Enums\QuestionType::OneCorrect)<x-question.one-correct :question='$question'></x-question.one-correct>@endif */}
        </div>
    </div>
}