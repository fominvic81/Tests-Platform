import React, { useState } from 'react';
import { Question, QuestionType, getUniqueId } from '../../../../api';
import { Option } from './Option';
import { FormToggle } from '../../form/toggle';

interface Props {
    question: Question<QuestionType.MultipleCorrect>;
}

export const MultipleCorrect: React.FC<Props> = ({ question }) => {

    const [options, setOptions] = useState(question.data.options);
    const [answer, setAnswer] = useState(question.data.answer);
    const [optoinKeys, setOptionKeys] = useState(options.map(() => getUniqueId()));

    return <>
            <FormToggle name='data[settings][showAmountOfCorrect]' label='Показуват кількість правильних відповідей?' defaultChecked={ question.data.settings.showAmountOfCorrect }></FormToggle>
            <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
            {answer.correct.map((isCorrect, index) => <input key={ index } type='hidden' name={`data[answer][correct][${index}]`} value={ isCorrect ? 1 : 0 } />)}
            { options.map((option, index) => <React.Fragment key={ optoinKeys[index] }>
                <div>
                    <input
                        type='checkbox'
                        id={`correct-${index}`}
                        checked={ answer.correct[index] }
                        onChange={(event) => {
                            setAnswer({ correct: answer.correct.map((isCorrect, i) => i === index ? event.target.checked : isCorrect) });
                        }}
                        className='hidden peer'
                    />
                    <label htmlFor={`correct-${index}`} className='block w-10 h-10 bg-gray-300 peer-checked:bg-emerald-400 rounded-xl'></label>
                </div>
                <Option
                    name='data[options]'
                    index={ index }
                    option={ option }
                    deletable={ options.length > 2 }
                    onDelete={() => {
                        setOptions(options.filter((opt) => opt !== option));
                        setOptionKeys(optoinKeys.filter((key) => key !== optoinKeys[index]));
                        setAnswer({ correct: answer.correct.filter((c, i) => i != index)});
                    }}
                ></Option>
            </React.Fragment>)}
            <button
                type='button'
                className='col-span-2 bg-emerald-400 p-2 rounded'
                onClick={() => {
                    setOptions([...options, { text: '' }]);
                    setOptionKeys([...optoinKeys, getUniqueId()]);
                    setAnswer({ correct: [...answer.correct, false] });
                }}
            >Додати</button>
        </div>
    </>
}