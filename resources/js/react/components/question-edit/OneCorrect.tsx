import React, { useState } from 'react';
import { OptionByType, Question, QuestionType, getOptionId } from '../../../api';
import { FormTextInput } from '../form/input';
import { TextEditor } from '../TextEditor';
import { Option } from './Option';

interface Props {
    initialOptions: OptionByType<QuestionType.OneCorrect>[];
}

export const OneCorrect: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    return <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
        { options.map((option, index) => <React.Fragment key={ option.id }>
            <div className='group'>
                <input
                    type='checkbox'
                    id={`correct-${index}`}
                    checked={ option.correct }
                    onChange={() => {
                        setOptions(options.map((opt, idx) => ({ ...opt, correct: idx === index })));
                    }}
                    className='hidden peer'
                />
                <label htmlFor={`correct-${index}`} className='block w-10 h-10 bg-gray-300 peer-checked:bg-emerald-400 rounded-full'></label>
                <input type='hidden' id={`correct-${index}`} name={`options[${index}][correct]`} value={ option.correct ? 1 : 0 } />
            </div>
            <Option
                index={ index }
                option={ option }
                deletable={ options.length > 2 }
                onDelete={() => {
                    setOptions(options.filter((opt) => opt !== option));
                }}
            ></Option>
        </React.Fragment>)}
        <button
            type='button'
            className='col-span-2 bg-emerald-400 p-2 rounded'
            onClick={() => {
                setOptions([...options, { id: getOptionId(), text: '', correct: false }]);
            }}
        >Додати</button>
    </div>
}