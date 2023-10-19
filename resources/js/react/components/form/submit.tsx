import React, { PropsWithChildren } from 'react';

interface Props extends PropsWithChildren {
    disabled?: boolean;
}

export const FormSubmit: React.FC<Props> = ({ disabled, children }) =>
    <button className='w-full h-10 mt-5 bg-sky-500 disabled:brightness-75 border border-blue-400 rounded' type='submit' disabled={ disabled }>{ children }</button>;