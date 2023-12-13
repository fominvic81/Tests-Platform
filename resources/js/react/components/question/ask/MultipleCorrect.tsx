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
        {question.data.settings.showAmountOfCorrect && <div>{
            question.data.amountOfCorrect! % 10 >= 5 || question.data.amountOfCorrect! % 10 === 0 || (((question.data.amountOfCorrect! / 10) % 10) | 0) === 1 ? `${question.data.amountOfCorrect} правильних відповідей` :
            question.data.amountOfCorrect! % 10 === 1 ? `${question.data.amountOfCorrect} правильна відповідь` :
            `${question.data.amountOfCorrect} правильні відповіді`
        }</div>}
        {chosen.map((value, index) => <input type='hidden' name={`answer[correct][${index}]`} value={ value ? 1 : 0 } key={ index } />)}
        {question.data.options.map((option, index) => 
            <label key={ index } className='flex items-center'>
                <input
                    type='checkbox'
                    className='w-8 h-8 appearance-none border-2 border-gray-400 checked:bg-emerald-400 rounded'
                    checked={ chosen[index] }
                    onChange={(event) => {
                        setChosen(chosen.map((value, i) => index === i ? event.target.checked : value))
                    }}
                />
                {option.image && <div className='w-48 h-40'><img className='w-full h-full object-contain' src={ imagePath(option.image) } /></div>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </label>
        )}
    </div>
}