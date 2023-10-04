import React from 'react';
import { Question, QuestionDataByType, QuestionType } from '../../../api';
import { FormTextInput } from '../form/input';


interface Props {
    data: QuestionDataByType<QuestionType.OneCorrect>;
    onChange: (data: QuestionDataByType<QuestionType.OneCorrect>) => any;
}

export const QuestionOneCorrect: React.FC<Props> = ({ data, onChange }) => {

    const onChangeCorrect = (index: number, value: boolean) => {
        const options = data.options;
        options[index] = { ...options[index], correct: value };
        onChange({ ...data })
    }
    const onChangeText = (index: number, value: string) => {
        const options = data.options;
        options[index] = { ...options[index], text: value };
        onChange({ ...data })
    }

    return <div className='grid grid-cols-[auto_1fr_auto] gap-2 items-center'>
        { data.options.map((value, index) => <React.Fragment key={index}>
            <div className='group'>
                <input
                    type='checkbox'
                    id={`correct-${index}`}
                    checked={ value.correct }
                    onChange={(event) => onChangeCorrect(index, event.target.checked)}
                    className='hidden peer'
                />
                <label htmlFor={`correct-${index}`} className='block w-10 h-10 bg-gray-300 peer-checked:bg-emerald-400 rounded-full'></label>
                <input type='hidden' id={`correct-${index}`} name={`data[options][${index}][correct]`} value={ Number(value.correct) } />
            </div>
            <FormTextInput
                type='text'
                name={`data[options][${index}][text]`}
                placeholder='Варіант'
                value={ value.text }
                onChange={(v) => onChangeText(index, v)}
            ></FormTextInput>
            <div className='w-40'></div>
        </React.Fragment>)}
    </div>
}