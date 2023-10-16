import React from 'react';
import { OptionByType, QuestionType } from '../../../api';
import cn from 'classnames';
import { ImageContain } from './ImageContain';
import { storagePath } from '../../../api/storagePath';

interface Props {
    options: OptionByType<QuestionType.MultipleCorrect>[];
}

export const MultipleCorrect: React.FC<Props> = ({ options }) => {
    return <div className='grid grid-cols-2'>
        {options.map((option) => 
            <div key={ option.id } className='flex items-center'>
                <div className={cn('w-5 h-5 rounded-md mr-1', option.correct ? 'bg-green-500' : 'bg-gray-300')}></div>
                {option.image && <ImageContain src={ storagePath(option.image) }></ImageContain>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </div>
        )}
    </div>
}