import cn from 'classnames';
import React, { useRef, useState } from 'react';


interface Props {
    name: string;
    nameDel: string;
    defaultSrc?: string;
    onChange?: () => any;
}

export const FormImage: React.FC<Props> = ({ name, nameDel, defaultSrc, onChange }) => {
    
    const imageTypes = ['image/png', 'image/gif', 'image/jpeg', 'image/jpg'];
    const [image, setImage] = useState(defaultSrc);
    const [dragOver, setDragOver] = useState(false);
    const fileInput = useRef<HTMLInputElement>(null);

    return <label
        className={cn('w-full h-full border-2 border-dashed relative flex items-center justify-center bg-opacity-40 transition-all', dragOver && 'bg-gray-500 brightness-75')}
        onDragEnter={() => setDragOver(true)}
        onDragLeave={() => setDragOver(false)}
        onDragOver={(event) => event.preventDefault()}
        onDrop={(event) => {
            event.preventDefault();
            setDragOver(false);
            const file = event.dataTransfer.files.item(0);
            if (!file) return;
            if (!imageTypes.includes(file.type)) return;
            fileInput.current!.files = event.dataTransfer.files;
            setImage(URL.createObjectURL(file));
        }}
    >
        <img className='max-w-full max-h-full pointer-events-none' src={ image ?? '/images/add-image.png' } alt='Зоображення' />
        <div className='absolute w-full py-1 text-center bottom-0 bg-gray-200 bg-opacity-40 border-t pointer-events-none'>{ image ? 'Видалити' : 'Додати зображення' }</div>
        <input
            ref={ fileInput }
            type='file'
            name={ name }
            accept='image/*'
            className='hidden'
            onClick={(event) => {
                if (image) {
                    event.preventDefault();
                    setImage(undefined);
                    if (onChange) onChange();

                    event.currentTarget.value = '';
                }
            }}
            onChange={(event) => {
                const file = event.target.files?.item(0);

                if (file) setImage(URL.createObjectURL(file));
                if (onChange) onChange();
            }}
        />
        <input type='hidden' name={ nameDel } value={ !image ? 1 : 0 } />
    </label>
}