import React from 'react';
import { Question, QuestionType } from '../../../../api';
import cn from 'classnames';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.OneCorrect>;
}

export const OneCorrect: React.FC<Props> = ({ question }) => {
    return <div>
        {question.data.options.map((option, index) => 
            <div key={ index } className='flex items-center'>
                <div className={cn('w-5 h-5 rounded-full mr-1', question.data.answer.correct[index] ? 'bg-green-500' : 'bg-gray-300')}></div>
                {option.image && <ImageContain src={ imagePath(option.image) }></ImageContain>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </div>
        )}
    </div>
}