import React, { useState } from 'react';
import { Question, QuestionType } from '../../../../api';
import { ImageContain } from '../../common/ImageContain';
import { imagePath } from '../../../../api/storagePath';

interface Props {
    question: Question<QuestionType.Sequence, false>;
}

export const Sequence: React.FC<Props> = ({ question }) => {
    
    const [sequence, setSequence] = useState(question.data.answer?.sequence ?? question.data.options.map((o, index) => index));

    const swap = (i: number, j: number) => {
        if (i < 0 || i >= sequence.length || j < 0 || j >= sequence.length) return;
        const newSequence = [...sequence];
        [newSequence[i], newSequence[j]] = [newSequence[j], newSequence[i]];
        setSequence(newSequence);
    }

    return <div className='grid gap-2'>
        {sequence.map((seq_index, index) => <input key={ index } type='hidden' name={`answer[sequence][${index}]`} value={ seq_index }/>)}
        {sequence.map((seq_index, index) => {
            const option = question.data.options[seq_index];
            return <div className='flex items-center justify-start' key={ seq_index }>
                <div>
                    <button type='button' onClick={() => swap(index, index - 1)} className='border-2 rounded-full w-9 h-9 mr-1'>/\</button>
                    <button type='button' onClick={() => swap(index, index + 1)} className='border-2 rounded-full w-9 h-9'>\/</button>
                </div>
                <div className='flex items-center'>
                    {option.image && <ImageContain src={ imagePath(option.image) }></ImageContain>}
                    <div className='ml-1 my-2' dangerouslySetInnerHTML={{ __html: option.text }}></div>
                </div>
            </div>
        })}
    </div>
}