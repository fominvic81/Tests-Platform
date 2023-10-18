import React, { useState } from 'react';


interface Props {
    name: string;
    nameDel: string;
    defaultSrc?: string;
}

export const FormImage: React.FC<Props> = ({ name, nameDel, defaultSrc }) => {
    
    const [image, setImage] = useState(defaultSrc);

    return <label className='w-full h-full border-2 border-dashed relative flex items-center justify-center'>
        <img className='max-w-full max-h-full' src={ image ?? '/images/add-image.png' } alt='Зоображення' />
        <div className='absolute w-full py-1 text-center bottom-0 bg-gray-200 bg-opacity-40 border-t'>{ image ? 'Видалити' : 'Додати зображення' }</div>
        <input
            type='file'
            name={ name }
            accept='image/*'
            className='hidden'
            onClick={(event) => {
                if (image) {
                    event.preventDefault();
                    setImage(undefined);

                    event.currentTarget.value = '';
                }
            }}
            onChange={(event) => {
                const file = event.target.files?.item(0);

                if (file) setImage(URL.createObjectURL(file));
            }}
        />
        <input type='hidden' name={ nameDel } value={ !image ? 1 : 0 } />
    </label>
}