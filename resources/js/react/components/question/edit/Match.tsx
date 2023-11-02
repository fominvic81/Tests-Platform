import React, { useState } from 'react';
import { Question, QuestionType, getUniqueId } from '../../../../api';
import { Option } from './Option';

interface Props {
    question: Question<QuestionType.Match>;
}

export const Match: React.FC<Props> = ({ question }) => {

    const [options, setOptions] = useState(question.data.options);
    const [variants, setVariants] = useState(question.data.variants);
    const [answer, setAnswer] = useState(question.data.answer);
    const [optoinKeys, setOptionKeys] = useState(options.map(() => getUniqueId()));
    const [variantKeys, setVariantKeys] = useState(variants.map(() => getUniqueId()));

    return <div className='grid grid-cols-2 gap-2 items-start'>
        {answer.match.map((match, index) => <input key={ index } type='hidden' name={`data[answer][match][${index}]`} value={ match } />)}
        <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
            { options.map((option, index) => <React.Fragment key={ optoinKeys[index] }>
                <div className='text-xl font-bold'>{ index + 1 }</div>
                <Option
                    name='data[options]'
                    index={ index }
                    option={ option }
                    deletable={ options.length > 2 }
                    onDelete={() => {
                        setOptions(options.filter((opt) => opt !== option));
                        setAnswer({ match: answer.match.filter((m, i) => i !== index) });
                        setOptionKeys(optoinKeys.filter((key) => key !== optoinKeys[index]));
                    }}
                ></Option>
            </React.Fragment>)}
            <button
                type='button'
                className='bg-emerald-400 col-span-2 p-2 rounded'
                onClick={() => {
                    setOptions([...options, { text: '' }]);
                    setAnswer({ match: [...answer.match, -1] });
                    setOptionKeys([...optoinKeys, getUniqueId()]);
                }}
            >Додати</button>
        </div>
        <div className='grid grid-cols-[auto_1fr] gap-2 items-center'>
            { variants.map((variant, index) => <React.Fragment key={ variantKeys[index] }>
                <div className='text-xl font-bold'>{ String.fromCharCode(65 + index) }</div>
                <Option
                    name='data[variants]'
                    index={ index }
                    option={ variant }
                    deletable={ variants.length > 2 }
                    onDelete={() => {
                        setVariants(variants.filter((opt) => opt !== variant));
                        setAnswer({ match: answer.match.map((match) => match === index ? -1 : match - (match > index ? 1 : 0)) })
                        setVariantKeys(variantKeys.filter((key) => key !== variantKeys[index]));
                    }}
                ></Option>
            </React.Fragment>)}
            <button
                type='button'
                className='bg-emerald-400 col-span-2 p-2 rounded'
                onClick={() => {
                    setVariants([...variants, { text: '' }]);
                    setVariantKeys([...variantKeys, getUniqueId()]);
                }}
            >Додати</button>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        {variants.map((variant, index) => <th key={ index }><center>{ String.fromCharCode(65 + index) }</center></th>)}
                    </tr>
                </thead>
                <tbody>
                    {answer.match.map((match, i) => <tr key={ i }>
                        <th className='px-1'>{ i + 1 }</th>
                        {variants.map((v, j) => <td key={ j }>
                            <input
                                type='checkbox'
                                className='appearance-none block w-7 h-7 bg-gray-50 rounded border checked:bg-sky-300 transition-colors'
                                checked={ match === j }
                                onChange={() => {
                                    setAnswer({
                                        match: answer.match.map((m, index) => index === i ? j : (m === j ? -1 : m)),
                                    });
                                }}
                            />
                        </td>)}
                    </tr>)}
                </tbody>
            </table>
        </div>
    </div>
}
