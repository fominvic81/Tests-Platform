import React from 'react';
import { ValidationError } from '../../../api';

interface Props {
    error?: ValidationError;
}

export const FormError: React.FC<Props> = ({ error }) => {
    if (!error) return;

    return <div className='text-red-500'>{ error.message }</div>
}