import React from 'react';
import { OptionByType, QuestionType } from '../../../api';
import cn from 'classnames';

interface Props {
    options: OptionByType<QuestionType.MultipleCorrect>[];
}

export const MultipleCorrect: React.FC<Props> = ({ options }) => {
    return <div className='grid grid-cols-2'>
        {options.map((option, index) => 
            <div key={ index } className='flex items-center'>
                <div className={cn('w-5 h-5 rounded-md mr-2', option.correct ? 'bg-green-500' : 'bg-gray-300')}></div>
                <div key={ index } className='my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </div>
        )}
    </div>
}