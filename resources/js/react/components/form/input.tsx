import React, { useId } from 'react';

interface Props {
    type: 'email' | 'number' | 'password' | 'search' | 'text';
    name: string;
    placeholder?: string;
    label?: string;
    value?: any;
    defaultValue?: any;
    onChange?: (value: any) => any;
}

export const FormTextInput: React.FC<Props> = ({ type, name, placeholder, value, defaultValue, onChange, label }) => {
    const id = `${name}-${useId()}`

    return <>
        {label && <label htmlFor={ id }>{ label }</label>}
        <input
            className='w-full h-8 bg-gray-50 border border-gray-300 indent-1'
            type={ type }
            name={ name }
            id={ id }
            placeholder={ placeholder }
            value={ value }
            defaultValue={ defaultValue }
            onChange={(event) => onChange && onChange(event.target.value)}
        />
    </>
}