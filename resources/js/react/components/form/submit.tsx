import React, { PropsWithChildren } from 'react';

export const FormSubmit: React.FC<PropsWithChildren> = ({ children }) =>
    <button className='w-full h-10 mt-5 bg-sky-500 border border-blue-400 rounded' type='submit'>{ children }</button>;