import React, { useState } from 'react';
import { Answer, Question, QuestionType } from '../../../../api';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.Match, false>;
}

export const Match: React.FC<Props> = ({ question }) => {

    const options = question.data.options;
    const variants = question.data.variants;
    const [answer, setAnswer] = useState<Answer<QuestionType.Match>>(question.data.answer ?? { match: options.map(() => -1) });

    return <div className='grid grid-cols-2'>
        {answer.match.map((match, index) => <input key={ index } type='hidden' name={`answer[match][${index}]`} value={ match } />)}
        <div>
            {options.map((option, index) =>
                <div key={ option.text } className='flex items-center'>
                    <div className='mr-1 pr-1 font-bold border-r-4'>{ index + 1 }</div>
                    {option.image && <ImageContain src={ imagePath(option.image) }></ImageContain>}
                    <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
                </div>
            )}
        </div>
        <div>
            {variants.map((variant, index) =>
                <div key={ variant.text } className='flex items-center'>
                    <div className='mr-1 pr-1 font-bold border-r-4'>{ String.fromCharCode(65 + index) }.</div>
                    {variant.image && <ImageContain src={ imagePath(variant.image) }></ImageContain>}
                    <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: variant.text }}></div>
                </div>
            )}
        </div>
        <table className='w-fit col-span-2'>
            <thead>
                <tr>
                    <th></th>
                    {variants.map((variant, index) => <th key={ index }>{ String.fromCharCode(65 + index) }</th>)}
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
}