import React, { useState } from 'react';
import { OptionByType, Question, QuestionType } from '../../../api';
import { FormTextInput } from '../form/input';
import { Option } from './Option';

interface Props {
    initialOptions: OptionByType<QuestionType.MultipleCorrect>[];
}

export const MultipleCorrect: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    const onChangeValue = <T extends keyof OptionByType<QuestionType.MultipleCorrect>>(index: number, key: T, value: OptionByType<QuestionType.MultipleCorrect>[T]) => {
        const newOption = { ...options[index], [key]: value};
        setOptions(options.map((option, i) => i === index ? newOption : option));
    }

    return <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
        { options.map((option, index) => <React.Fragment key={ index }>
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
            <Option
                index={ index }
                option={ option }
                deletable={ options.length > 2 }
                onDelete={() => {
                    setOptions([...options.filter((o, idx) => idx !== index)]);
                }}
            ></Option>
        </React.Fragment>)}
        <button
            type='button'
            className='col-span-2 bg-emerald-400 p-2 rounded'
            onClick={() => {
                setOptions([...options, { text: '', correct: false }]);
            }}
        >Додати</button>
    </div>
}