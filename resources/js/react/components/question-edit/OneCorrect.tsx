import React, { useState } from 'react';
import { OptionByType, Question, QuestionType } from '../../../api';
import { FormTextInput } from '../form/input';

interface Props {
    initialOptions: OptionByType<QuestionType.OneCorrect>[];
}

export const QuestionOneCorrect: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    const onChangeValue = <T extends keyof OptionByType<QuestionType.OneCorrect>>(index: number, key: T, value: OptionByType<QuestionType.OneCorrect>[T]) => {
        const newOption = { ...options[index], [key]: value};
        setOptions(options.map((option, i) => i === index ? newOption : option));
    }

    return <div className='grid grid-cols-[auto_1fr_auto_auto] gap-2 items-center'>
        { options.map((option, index) => <React.Fragment key={index}>
            <div className='group'>
                <input
                    type='checkbox'
                    id={`correct-${index}`}
                    checked={ option.correct }
                    onChange={(event) => onChangeValue(index, 'correct', event.target.checked)}
                    className='hidden peer'
                />
                <label htmlFor={`correct-${index}`} className='block w-10 h-10 bg-gray-300 peer-checked:bg-emerald-400 rounded-full'></label>
                <input type='hidden' id={`correct-${index}`} name={`options[${index}][correct]`} value={ option.correct ? 1 : 0 } />
            </div>
            <FormTextInput
                type='text'
                name={`options[${index}][text]`}
                placeholder='Варіант'
                value={ option.text }
                onChange={(value) => onChangeValue(index, 'text', value)}
            ></FormTextInput>
            <div className='w-40'></div>
            <button
                type='button'
                className='w-8 aspect-square bg-red-600 rounded'
                onClick={() => {
                    console.log(index);
                    setOptions(options.filter((v, idx) => index !== idx))
                }}
            >D</button>
        </React.Fragment>)}
        <button
            type='button'
            className='col-span-4 bg-emerald-400 p-2 rounded'
            onClick={() => {
                setOptions([ ...options, { text: '', correct: false } ]);
            }}
        >Додати</button>
    </div>
}