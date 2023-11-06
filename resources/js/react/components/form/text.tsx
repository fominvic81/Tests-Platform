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

    return <div>
        {label && <label htmlFor={ name }>{ label }</label>}
        <input
            className='w-full py-1 border-2 rounded indent-1'
            type={ type }
            name={ name }
            id={ name }
            placeholder={ placeholder }
            value={ value }
            defaultValue={ defaultValue }
            onChange={(event) => onChange && onChange(event.target.value)}
        />
    </div>
}