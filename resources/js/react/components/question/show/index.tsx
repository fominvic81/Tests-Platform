import React, { useEffect, useState } from 'react';
import { Question, QuestionType, QuestionTypeName } from '../../../../api';
import { imagePath } from '../../../../api/storagePath';
import { OneCorrect } from './OneCorrect';
import { MultipleCorrect } from './MultipleCorrect';
import { TextInput } from './TextInput';
import { Match } from './Match';
import { ImageContain } from '../../common/ImageContain';
import { Sequence } from './Sequence';
import cn from 'classnames';

import DeleteSVG from '../../../../../svg/common/delete.svg?react';
import CancelSVG from '../../../../../svg/common/cancel.svg?react';
import EditSVG from '../../../../../svg/common/edit.svg?react';

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
    onDelete: () => any;
    onEdit:() => any;
}

export const QuestionShow: React.FC<Props> = ({ question, index, onDelete, onEdit }) => {

    const [confirmDelete, setConfirmDelete] = useState(false);
    const Component = questionComponentByType[question.type];

    return <div className='bg-white p-3 my-4 shadow-md rounded-lg'>
        <div>
            <div className='flex justify-between items-center'>
                <div>
                    <div className='inline-block border-2 px-2 rounded mr-2 font-mono font-semibold'>№{ index + 1 }</div>
                    <div className='inline-block border-2 px-2 rounded mr-2 font-mono font-semibold'> { QuestionTypeName[question.type] } </div>
                </div>
                <div>
                    <button
                        type='button'
                        className='inline mx-1 p-1 w-9 h-9 transition-colors border-2 border-gray-200 rounded hover:bg-gray-200'
                        onClick={ onEdit }
                    ><EditSVG></EditSVG></button>
                    {confirmDelete && <button
                        type='button'
                        className='inline mx-1 p-1 w-9 h-9 transition-colors border-2 border-gray-200 rounded hover:bg-gray-200'
                        onClick={() => {
                            setConfirmDelete(false);
                        }}
                    ><CancelSVG></CancelSVG></button>}
                    <button
                        type='button'
                        className={cn('inline mx-1 p-1 w-9 h-9 transition-colors border-2 border-gray-200 rounded hover:bg-red-500', confirmDelete && 'bg-red-500')}
                        onClick={(event) => {
                            event.stopPropagation();
                            if (confirmDelete) {
                                onDelete();
                            } else {
                                setConfirmDelete(true);
                            }
                        }}
                    ><DeleteSVG></DeleteSVG></button>
                </div>
            </div>
            <div className='grid grid-cols-[auto_1fr]'>
                {question.image && <ImageContain src={ imagePath(question.image) }></ImageContain>}
                <div
                    className='ml-3 mt-1'
                    dangerouslySetInnerHTML={{ __html: question.text }}
                ></div>
            </div>
            <hr className='my-3' />
            <Component question={ question }></Component>
        </div>
    </div>
}