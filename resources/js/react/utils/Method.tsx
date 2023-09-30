import React from 'react';

interface Props {
    method: 'POST' | 'PUT' | 'PATCH' | 'DELETE';
}

export const Method: React.FC<Props> = ({ method }) => {
    return <input type='hidden' name='_method' value={ method } />
}