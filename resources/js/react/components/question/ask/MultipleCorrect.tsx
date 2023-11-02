import React, { useState } from 'react';
import { Question, QuestionType } from '../../../../api';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.MultipleCorrect, false>;
}

export const MultipleCorrect: React.FC<Props> = ({ question }) => {

    const [chosen, setChosen] = useState(question.data.answer?.correct ?? question.data.options.map(() => false));

    return <div>
        {chosen.map((value, index) => <input type='hidden' name={`answer[correct][${index}]`} value={ value ? 1 : 0 } key={ index } />)}
        {question.data.options.map((option, index) => 
            <label key={ index } className='flex items-center'>
                <input
                    type='checkbox'
                    className='w-8 h-8 appearance-none bg-gray-100 checked:bg-emerald-400 rounded'
                    checked={ chosen[index] }
                    onChange={(event) => {
                        setChosen(chosen.map((value, i) => index === i ? event.target.checked : value))
                    }}
                />
                {option.image && <ImageContain src={ imagePath(option.image) }></ImageContain>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </label>
        )}
    </div>
}