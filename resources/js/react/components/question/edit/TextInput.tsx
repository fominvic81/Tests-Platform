import React, { useState } from 'react';
import { Question, QuestionType, getUniqueId } from '../../../../api';
import { FormTextInput } from '../../form/text';
import { FormToggle } from '../../form/toggle';

interface Props {
    question: Question<QuestionType.TextInput>;
}

export const TextInput: React.FC<Props> = ({ question }) => {

    const [answer, setAnswer] = useState(question.data.answer);
    const [keys, setKeys] = useState(answer.texts.map(() => getUniqueId()));

    return <>
        <FormToggle name='data[settings][registerMatters]' label='Враховувати регістр букв?' defaultChecked={ question.data.settings.registerMatters }></FormToggle>
        <FormToggle name='data[settings][whitespaceMatters]' label='Враховувати пробіл?' defaultChecked={ question.data.settings.whitespaceMatters }></FormToggle>
        <div className='grid grid-cols-[1fr_auto] gap-2'>
            {answer.texts.map((text, index) => <React.Fragment key={ keys[index] }>
                <div className='overflow-hidden'>
                    <FormTextInput
                        type='text'
                        name={`data[answer][texts][${index}]`}
                        placeholder='Варіант'
                        defaultValue={ text }
                    ></FormTextInput>
                </div>
                <button
                    type='button'
                    className='w-8 aspect-square bg-red-600 rounded disabled:bg-gray-600'
                    disabled={ answer.texts.length <= 1 }
                    onClick={() => {
                        setAnswer({ texts: answer.texts.filter((t, i) => i !== index) });
                        setKeys(keys.filter((k, i) => i !== index));
                    }}
                >D</button>
            </React.Fragment>)}
            <button
                type='button'
                className='col-span-2 bg-emerald-400 p-2 rounded'
                onClick={() => {
                    setAnswer({ texts: [...answer.texts, ''] });
                    setKeys([...keys, getUniqueId()]);
                }}
            >Додати</button>
        </div>
    </>;
}