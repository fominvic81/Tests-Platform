import React, { useId } from 'react';

interface Props {
    name: string;
    placeholder?: string;
    label?: string;
    value?: any;
    defaultValue?: any;
    onChange?: (value: any) => any;
}

export const FormTextarea: React.FC<Props> = ({ name, placeholder, value, defaultValue, onChange, label }) => {

    return <div>
        {label && <label htmlFor={ name }>{ label }</label>}
        <textarea
            className='w-full h-15 border-2 rounded indent-1'
            name={ name }
            id={ name }
            placeholder={ placeholder }
            value={ value }
            defaultValue={ defaultValue }
            onChange={ (event) => onChange && onChange(event.target.value) }
        />
    </div>
}