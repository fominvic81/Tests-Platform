import React, { PropsWithChildren } from 'react';

interface Props extends PropsWithChildren {
    disabled?: boolean;
}

export const FormSubmit: React.FC<Props> = ({ disabled, children }) =>
    <button className='w-full py-1 bg-sky-500 border border-blue-400 rounded disabled:brightness-75' type='submit' disabled={ disabled }>{ children }</button>;