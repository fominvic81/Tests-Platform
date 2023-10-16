import React, { useState } from 'react';
import { OptionByType, QuestionType, getOptionId } from '../../../api';
import { FormTextInput } from '../form/input';

interface Props {
    initialOptions: OptionByType<QuestionType.TextInput>[];
}

export const TextInput: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    return <div className='grid grid-cols-[1fr_auto] gap-2'>
        {options.map((option, index) => <React.Fragment key={ option.id }>
            <input type='hidden' name={`options[${index}][id]`} value={ option.id } />
            <div className='overflow-hidden'>
                <FormTextInput
                    type='text'
                    name={`options[${index}][text]`}
                    placeholder='Варіант'
                    defaultValue={ option.text }
                ></FormTextInput>
            </div>
            <button
                type='button'
                className='w-8 aspect-square bg-red-600 rounded disabled:bg-gray-600'
                disabled={ options.length <= 1 }
                onClick={() => {
                    setOptions(options.filter((opt) => opt !== option));
                }}
            >D</button>
        </React.Fragment>)}
        <button
            type='button'
            className='col-span-2 bg-emerald-400 p-2 rounded'
            onClick={() => {
                setOptions([...options, { id: getOptionId(), text: '' }]);
            }}
        >Додати</button>
    </div>;
}