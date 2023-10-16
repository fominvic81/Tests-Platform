import React from 'react';
import { OptionByType, QuestionType } from '../../../api';
import { ImageContain } from './ImageContain';
import { storagePath } from '../../../api/storagePath';

interface Props {
    options: OptionByType<QuestionType.Sequence>[];
}

export const Sequence: React.FC<Props> = ({ options }) => {
    return <div className='grid gap-2'>
        {options.map((option, index) => 
            <div className='flex items-center' key={ option.id }>
                <div className='mr-1 pr-1 font-bold border-r-4'>{ index + 1 }</div>
                {option.image && <ImageContain src={ storagePath(option.image) }></ImageContain>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </div>
        )}
    </div>
}