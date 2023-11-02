import React, { useState } from 'react';
import { Question, QuestionType } from '../../../../api';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.Match>;
}

export const Match: React.FC<Props> = ({ question }) => {

    return <div className='grid grid-cols-2'>
        <div>
            {question.data.options.map((option, index) =>
                <div key={ index } className='flex items-center'>
                    <div className='mr-1 pr-1 font-bold border-r-4'>{ index + 1 }</div>
                    {option.image && <ImageContain src={ imagePath(option.image) }></ImageContain>}
                    <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
                </div>
            )}
        </div>
        <div>
            {question.data.variants.map((variant, index) =>
                <div key={ index } className='flex items-center'>
                    <div className='mr-1 pr-1 font-bold border-r-4'>{ String.fromCharCode(65 + index) }.</div>
                    {variant.image && <ImageContain src={ imagePath(variant.image) }></ImageContain>}
                    <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: variant.text }}></div>
                </div>
            )}
        </div>
        <div className='col-span-2 flex'>
            {question.data.answer.match.map((match, index) => {
                if (match === -1) return;
                return <div key={ index } className='border-2 px-2 mx-1 rounded-full'>{ index + 1 } =&gt; { String.fromCharCode(65 + match) }</div>
            })}
        </div>
    </div>
}