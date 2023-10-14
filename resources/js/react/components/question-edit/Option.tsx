import React from 'react';
import { TextEditor } from '../TextEditor';
import { OptionByType, QuestionType } from '../../../api';

interface Props {
    index: number;
    option: OptionByType<QuestionType>;
    deletable: boolean;
    onDelete: () => any;
}

export const Option: React.FC<Props> = ({ index, option, deletable, onDelete }) => {
    return <div className='grid grid-cols-[1fr_auto_auto] items-center gap-2'>
        <input type='hidden' name={ `options[${index}][id]` } value={ option.id } />
        <div className='overflow-hidden'>
            <TextEditor
                name={`options[${index}][text]`}
                placeholder='Варіант'
                defaultValue={ option.text }
            ></TextEditor>
        </div>
        <div className='w-32 h-full max-h-32 border-2 border-dashed'></div>
        <button
            type='button'
            className='w-8 aspect-square bg-red-600 rounded disabled:bg-gray-600'
            disabled={ !deletable }
            onClick={ onDelete }
        >D</button>
    </div>
}