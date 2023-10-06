import React, { useState } from 'react';
import { OptionByType, Question, QuestionType } from '../../../api';
import { FormTextInput } from '../form/input';

interface Props {
    initialOptions: OptionByType<QuestionType.OneCorrect>[];
}

export const QuestionOneCorrect: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);
    const onChangeCorrect = (index: number, value: boolean) => {
        const newOption = { ...options[index], correct: value};
        setOptions(options.map((option, i) => i === index ? newOption : option));
    }

    return <div className='grid grid-cols-[auto_1fr_auto] gap-2 items-center'>
        { options.map((value, index) => <React.Fragment key={index}>
            <div className='group'>
                <input
                    type='checkbox'
                    id={`correct-${index}`}
                    checked={ value.correct }
                    onChange={(event) => onChangeCorrect(index, event.target.checked)}
                    className='hidden peer'
                />
                <label htmlFor={`correct-${index}`} className='block w-10 h-10 bg-gray-300 peer-checked:bg-emerald-400 rounded-full'></label>
                <input type='hidden' id={`correct-${index}`} name={`options[${index}][correct]`} value={ value.correct ? 1 : 0 } />
            </div>
            <FormTextInput
                type='text'
                name={`options[${index}][text]`}
                placeholder='Варіант'
                defaultValue={ value.text }
            ></FormTextInput>
            <div className='w-40'></div>
        </React.Fragment>)}
    </div>
}