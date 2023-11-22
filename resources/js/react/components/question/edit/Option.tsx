import React from 'react';
import { TextEditor } from '../../TextEditor';
import { imagePath } from '../../../../api';
import { FormImage } from '../../form/image';

import DeleteSVG from '../../../../../svg/common/delete.svg?react';

interface Option {
    text: string;
    image?: string;
}

interface Props {
    name: string
    index: number;
    option: Option;
    deletable: boolean;
    onDelete: () => any;
}

export const Option: React.FC<Props> = ({ name: field, index, option, deletable, onDelete }) => {

    return <div className='grid grid-cols-[1fr_auto_auto] items-center gap-2'>
        <div className='col-span-full md:col-span-1 overflow-hidden'>
            <TextEditor
                name={`${field}[${index}][text]`}
                placeholder='Варіант'
                defaultValue={ option.text }
            ></TextEditor>
        </div>
        <div className='md:w-32 h-24 md:h-full md:max-h-32'>
            <FormImage
                name={`${field}[${index}][image]`}
                nameDel={`${field}[${index}][del_image]`}
                defaultSrc={ option.image && imagePath(option.image) }
            ></FormImage>
        </div>
        <button
            type='button'
            className='inline mx-1 p-1 w-9 h-9 transition-colors border-2 border-gray-200 rounded hover:bg-red-500 disabled:bg-gray-200'
            disabled={ !deletable }
            onClick={ onDelete }
        ><DeleteSVG></DeleteSVG></button>
    </div>
}