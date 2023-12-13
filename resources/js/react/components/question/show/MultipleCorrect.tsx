import React from 'react';
import { Question, QuestionType } from '../../../../api';
import cn from 'classnames';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.MultipleCorrect>;
}

export const MultipleCorrect: React.FC<Props> = ({ question }) => {
    return <div>
        {question.data.options.map((option, index) => 
            <div key={ index } className='flex items-center'>
                <div className={cn('w-5 h-5 rounded-md mr-1', question.data.answer.correct[index] ? 'bg-green-500' : 'bg-gray-300')}></div>
                {option.image && <div className='w-48 h-40'><img className='w-full h-full object-contain' src={ imagePath(option.image) } /></div>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </div>
        )}
    </div>
}