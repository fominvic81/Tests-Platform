import React from 'react';
import { OptionByType, QuestionType } from '../../../api';

interface Props {
    options: OptionByType<QuestionType.MultipleCorrect>[];
}

export const MultipleCorrect: React.FC<Props> = ({ options }) => {
    return <div className='grid grid-cols-2'>
        {options.map((option, index) => 
            <div key={ index } className={`flex items-center my-2 before:block before:w-5 before:h-5 before:rounded-md ${ option.correct ? 'before:bg-green-500' : 'before:bg-gray-300' } before:mr-1`}>
                { option.text }
            </div>
        )}
    </div>
}