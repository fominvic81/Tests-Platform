import React, { useState } from 'react';
import { Question, QuestionType } from '../../../../api';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.OneCorrect, false>;
}

export const OneCorrect: React.FC<Props> = ({ question }) => {
    const [chosen, setChosen] = useState(question.data.answer?.correct ?? question.data.options.map(() => false));

    return <div>
        {chosen.map((value, index) => <input type='hidden' name={`answer[correct][${index}]`} value={ value ? 1 : 0 } key={ index } />)}
        {question.data.options.map((option, index) => 
            <label key={ index } className='flex items-center'>
                <input
                    type='checkbox'
                    className='w-8 h-8 appearance-none border-2 border-gray-400 checked:bg-emerald-400 rounded-full'
                    checked={ chosen[index] }
                    onChange={() => {
                        setChosen(chosen.map((value, i) => index === i))
                    }}
                />
                {option.image && <ImageContain src={ imagePath(option.image) }></ImageContain>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </label>
        )}
    </div>
}