import React, { useState } from 'react';
import { OptionByType, QuestionType } from '../../../api';
import { ImageContain } from './ImageContain';
import { storagePath } from '../../../api/storagePath';

interface Props {
    options: OptionByType<QuestionType.Match>[];
}

export const Match: React.FC<Props> = ({ options: allOptions }) => {

    const options = allOptions.filter((option) => typeof option.match_id === 'number');
    const variants = allOptions.filter((option) => typeof option.match_id !== 'number');

    return <div className='grid grid-cols-2'>
        <div>
            {options.map((option, index) =>
                <div key={ option.id } className='flex items-center'>
                    <div className='mr-1 pr-1 font-bold border-r-4'>{ index + 1 }</div>
                    {option.image && <ImageContain src={ storagePath(option.image) }></ImageContain>}
                    <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
                </div>
            )}
        </div>
        <div>
            {variants.map((variant, index) =>
                <div key={ variant.id } className='flex items-center'>
                    <div className='mr-1 pr-1 font-bold border-r-4'>{ String.fromCharCode(65 + index) }.</div>
                    {variant.image && <ImageContain src={ storagePath(variant.image) }></ImageContain>}
                    <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: variant.text }}></div>
                </div>
            )}
        </div>
        <div className='col-span-2 flex'>
            {options.map((option, index) => {
                const match = variants.findIndex((variant) => option.match_id === variant.id);
                if (match === -1) return;
                return <div key={ option.id } className='bg-emerald-400 border border-gray-500 px-2 mx-1 rounded'>{ index + 1 } - { String.fromCharCode(65 + match) }</div>
            })}
        </div>
    </div>
}