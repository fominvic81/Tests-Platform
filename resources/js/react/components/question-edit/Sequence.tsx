import React, { useState } from 'react';
import { OptionByType, QuestionType, getOptionId } from '../../../api';
import { Option } from './Option';

import SwapSvg from '../../../../svg/editor/swap.svg?react';

interface Props {
    initialOptions: OptionByType<QuestionType.Sequence>[];
}

export const Sequence: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    return <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
        { options.map((option, index) => <React.Fragment key={ option.id }>
            <div className='text-lg font-bold'>{ String.fromCharCode(65 + options.findIndex((v) => v === option)) }</div>
            <input type='hidden' name={`options[${index}][sequence_index]`} value={ option.sequence_index } />
            <Option
                index={ index }
                option={ option }
                deletable={ options.length > 2 }
                onDelete={() => {
                    setOptions(options
                        .filter((opt) => opt !== option)
                        .map((opt) => ({ ...opt, sequence_index: opt.sequence_index - (opt.sequence_index > option.sequence_index ? 1 : 0) })));
                }}
            ></Option>
        </React.Fragment>)}
        <button
            type='button'
            className='col-span-2 bg-emerald-400 p-2 rounded'
            onClick={() => {
                setOptions([...options, { id: getOptionId(), text: '', sequence_index: Math.max(...options.map((v) => v.sequence_index)) + 1 }]);
            }}
        >Додати</button>
        <div className='col-span-2 flex border border-gray-400 w-min'>
            {[...options].sort((a, b) => a.sequence_index - b.sequence_index).map((option, index) =>
                <React.Fragment key={ index }>
                    {index > 0 && <button
                        type='button'
                        className='flex w-8 h-8 border items-center justify-center bg-yellow-200'
                        onClick={() => {
                            const option2 = options.find((v) => v.sequence_index === option.sequence_index - 1);
                            if (!option2) return;

                            setOptions((options) => options.map((value) => value === option2 ? { ...value, sequence_index: option.sequence_index } : value));
                            setOptions((options) => options.map((value) => value === option ? { ...value, sequence_index: option2.sequence_index } : value));
                        }}
                    ><SwapSvg className='w-3/4 h-3/4'></SwapSvg></button>}
                    <div className='flex w-8 h-8 items-center justify-center bg-gray-200 text-lg font-bold'>{ String.fromCharCode(65 + options.findIndex((v) => v === option)) }</div>
                </React.Fragment>
            )}
        </div>
    </div>
}