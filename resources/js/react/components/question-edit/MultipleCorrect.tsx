import React, { useState } from 'react';
import { OptionByType, Question, QuestionType } from '../../../api';
import { FormTextInput } from '../form/input';

interface Props {
    initialOptions: OptionByType<QuestionType.MultipleCorrect>[];
}

export const MultipleCorrect: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    const onChangeValue = <T extends keyof OptionByType<QuestionType.MultipleCorrect>>(index: number, key: T, value: OptionByType<QuestionType.MultipleCorrect>[T]) => {
        const newOption = { ...options[index], [key]: value};
        setOptions(options.map((option, i) => i === index ? newOption : option));
    }

    return <div className='grid grid-cols-[auto_1fr_auto_auto] gap-2 items-center'>
        { options.map((option, index) => <React.Fragment key={index}>
            <input type='hidden' name={`options[${index}][id]`} value={ option.id } />
            <div className='group'>
                <input
                    type='checkbox'
                    id={`correct-${index}`}
                    checked={ option.correct }
                    onChange={() => onChangeValue(index, 'correct', !option.correct)}
                    className='hidden peer'
                />
                <label htmlFor={`correct-${index}`} className='block w-10 h-10 bg-gray-300 peer-checked:bg-emerald-400 rounded-xl'></label>
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
            {options.length > 2 ? <button
                type='button'
                className='w-8 aspect-square bg-red-600 rounded'
                onClick={() => {
                    console.log(index);
                    setOptions(options.filter((v, idx) => index !== idx))
                }}
            >D</button> : <div></div>}
        </React.Fragment>)}
        <button
            type='button'
            className='col-span-4 bg-emerald-400 p-2 rounded'
            onClick={() => {
                setOptions([...options, { text: '', correct: false }]);
            }}
        >Додати</button>
    </div>
}