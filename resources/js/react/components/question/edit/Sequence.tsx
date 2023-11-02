import React, { useState } from 'react';
import { Question, QuestionType, getUniqueId } from '../../../../api';
import { Option } from './Option';

import SwapSvg from '../../../../../svg/editor/swap.svg?react';

interface Props {
    question: Question<QuestionType.Sequence>;
}

export const Sequence: React.FC<Props> = ({ question }) => {

    const [options, setOptions] = useState(question.data.options);
    const [answer, setAnswer] = useState(question.data.answer);
    const [optoinKeys, setOptionKeys] = useState(options.map(() => getUniqueId()));
    console.log(answer)


    return <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
        {answer.sequence.map((i, index) => <input key={ index } type='hidden' name={`data[answer][sequence][${index}]`} value={ i } />)}
        { options.map((option, index) => <React.Fragment key={ optoinKeys[index] }>
            <div className='text-lg font-bold'>{ String.fromCharCode(65 + options.findIndex((v) => v === option)) }</div>
            <Option
                name='data[options]'
                index={ index }
                option={ option }
                deletable={ options.length > 2 }
                onDelete={() => {
                    setOptions(options.filter((opt) => opt !== option));
                    setAnswer({ sequence: answer.sequence.filter((s, i) => i !== index).map((i) => i - (i > index ? 1 : 0)) });
                    setOptionKeys(optoinKeys.filter((key) => key !== optoinKeys[index]));
                }}
            ></Option>
        </React.Fragment>)}
        <button
            type='button'
            className='col-span-2 bg-emerald-400 p-2 rounded'
            onClick={() => {
                setOptions([...options, { text: '' }]);
                setAnswer({ sequence: [...answer.sequence, answer.sequence.length] });
                setOptionKeys([...optoinKeys, getUniqueId()]);
            }}
        >Додати</button>
        <div className='col-span-2 flex border border-gray-400 w-min'>
            {answer.sequence.map((i, index) =>
                <React.Fragment key={ index }>
                    {index > 0 && <button
                        type='button'
                        className='flex w-8 h-8 border items-center justify-center bg-yellow-200'
                        onClick={() => {
                            const newSequence = [...answer.sequence];
                            [newSequence[index], newSequence[index - 1]] = [newSequence[index - 1], newSequence[index]];
                            setAnswer({ sequence: newSequence });
                        }}
                    ><SwapSvg className='w-3/4 h-3/4'></SwapSvg></button>}
                    <div className='flex w-8 h-8 items-center justify-center bg-gray-200 text-lg font-bold'>{ String.fromCharCode(65 + i) }</div>
                </React.Fragment>
            )}
        </div>
    </div>
}