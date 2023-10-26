import React, { useState } from 'react';
import { OptionByType, QuestionType, getOptionId, getVariantId } from '../../../api';
import { Option } from './Option';

interface Props {
    initialOptions: OptionByType<QuestionType.Match>[];
}

export const Match: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions.filter((option) => typeof option.match_id === 'number'));
    const [variants, setVariants] = useState(initialOptions.filter((option) => typeof option.match_id !== 'number'));

    return <div className='grid grid-cols-2 gap-2 items-start'>
        <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
            { options.map((option, index) => <React.Fragment key={ option.id }>
                <input type='hidden' name={`options[${index}][match_id]`} value={ option.match_id } />
                <div className='text-xl font-bold'>{ index + 1 }</div>
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
                className='bg-emerald-400 col-span-2 p-2 rounded'
                onClick={() => {
                    setOptions([...options, { id: getOptionId(), text: '', match_id: 0 }]);
                }}
            >Додати</button>
        </div>
        <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
            { variants.map((variant, index) => <React.Fragment key={ variant.id }>
                <input type='hidden' name={`options[${options.length + index}][variant_id]`} value={ variant.variant_id } />
                <div className='text-xl font-bold'>{ String.fromCharCode(65 + index) }</div>
                <Option
                    index={ options.length + index }
                    option={ variant }
                    deletable={ variants.length > 2 }
                    onDelete={() => {
                        setVariants(variants.filter((opt) => opt !== variant));
                    }}
                ></Option>
            </React.Fragment>)}
            <button
                type='button'
                className='bg-emerald-400 col-span-2 p-2 rounded'
                onClick={() => {
                    setVariants([...variants, { id: getOptionId(), text: '', variant_id: getVariantId() }]);
                }}
            >Додати</button>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        {variants.map((variant, index) => <th key={ variant.id }><center>{ String.fromCharCode(65 + index) }</center></th>)}
                    </tr>
                </thead>
                <tbody>
                    {options.map((option, indexY) => <tr key={ option.id }>
                        <th className='px-1'>{ indexY + 1 }</th>
                        {variants.map((variant, indexX) => <td key={ variant.id }>
                            <input
                                id={ `match-${indexX}-${indexY}` }
                                type='checkbox'
                                className='appearance-none block w-7 h-7 bg-gray-50 rounded border checked:bg-sky-300 transition-colors'
                                checked={ option.match_id === variant.variant_id }
                                onChange={() => {
                                    setOptions(options
                                        .map((value) => value === option ? { ...option, match_id: value.match_id === variant.variant_id ? 0 : variant.variant_id } : value)
                                        .map((value) => value.id === option.id ? value : (value.match_id === variant.variant_id ? { ...value, match_id: 0 } : value)));
                                }}
                            />
                        </td>)}
                    </tr>)}
                </tbody>
            </table>
        </div>
    </div>
}
