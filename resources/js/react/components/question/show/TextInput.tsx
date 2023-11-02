import React from 'react';
import { Question, QuestionType } from '../../../../api';

interface Props {
    question: Question<QuestionType.TextInput>;
}

export const TextInput: React.FC<Props> = ({ question }) => {
    return <div>
        {question.data.answer.texts.map((text, index) => 
            <div key={ index } className='my-2 border-l-4 pl-2'>{ text }</div>
        )}
    </div>
}