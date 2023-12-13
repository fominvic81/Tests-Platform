import React from 'react';
import { Question, QuestionType } from '../../../../api';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.Sequence>;
}

export const Sequence: React.FC<Props> = ({ question }) => {
    return <div className='grid gap-2'>
        {question.data.options.map((option, index) => 
            <div className='flex items-center' key={ index }>
                <div className='mr-1 pr-1 font-bold border-r-4'>{ index + 1 }</div>
                {option.image && <div className='w-48 h-40'><img className='w-full h-full object-contain' src={ imagePath(option.image) } /></div>}
                <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
            </div>
        )}
        <div className='flex items-center gap-1'>
            {question.data.answer.sequence.map((seq_index) => <div className='w-7 h-7 border-2 rounded-full flex items-center justify-center' key={ seq_index }>
                { String.fromCharCode(65 + seq_index) }
            </div>)}
        </div>
    </div>
}