import React from 'react';

export const CSRF: React.FC = () => {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')!;
    return <input type='hidden' name='_token' value={ csrf } />
}