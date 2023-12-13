import React from 'react';

interface Props {
    src: string;
}

export const ImageContain: React.FC<Props> = ({ src }) => {
    return <img className='w-full h-full object-contain' src={ src } alt='Зображення' />
}