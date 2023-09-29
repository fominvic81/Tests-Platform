import React from 'react';
import { Question, QuestionType } from '../../../api';

interface Props {
    question: Question<QuestionType.OneCorrect>;
}

export const QuestionOneCorrect: React.FC<Props> = ({ question }) => {
    return <div className='grid grid-cols-2'>
        { question.data.options.map((option, index) =>
            <div key={index} className={`flex items-center my-2 before:block before:w-5 before:h-5 before:rounded-full ${option.correct ? 'before:bg-green-500' : 'before:bg-gray-300'} before:mr-1`}>
                { option.text }
            </div>)
        }
    </div>
}