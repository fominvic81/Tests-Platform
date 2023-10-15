import React from 'react';
import { TextEditor } from '../TextEditor';
import { OptionByType, QuestionType } from '../../../api';
import { FormImage } from '../form/image';
import { storagePath } from '../../../api/storagePath';

interface Props {
    index: number;
    option: OptionByType<QuestionType>;
    deletable: boolean;
    onDelete: () => any;
}

export const Option: React.FC<Props> = ({ index, option, deletable, onDelete }) => {

    const { image } = option as { image?: string };

    return <div className='grid grid-cols-[1fr_auto_auto] items-center gap-2'>
        <input type='hidden' name={ `options[${index}][id]` } value={ option.id } />
        <div className='overflow-hidden'>
            <TextEditor
                name={`options[${index}][text]`}
                placeholder='Варіант'
                defaultValue={ option.text }
            ></TextEditor>
        </div>
        <div className='w-32 h-full max-h-32 border-2 border-dashed'>
            <FormImage
                name={`options[${index}][image]`}
                nameDel={`options[${index}][delete_image]`}
                defaultSrc={ image && storagePath(image) }
            ></FormImage>
        </div>
        <button
            type='button'
            className='w-8 aspect-square bg-red-600 rounded disabled:bg-gray-600'
            disabled={ !deletable }
            onClick={ onDelete }
        >D</button>
    </div>
}