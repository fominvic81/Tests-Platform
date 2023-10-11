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
    const id = `${name}-${useId()}`

    return <>
        {label && <label htmlFor={ id }>{ label }</label>}
        <textarea
            className='w-full h-20 bg-gray-50 border border-gray-300 resize-y indent-1'
            name={ name }
            id={ id }
            placeholder={ placeholder }
            value={ value }
            defaultValue={ defaultValue }
            onChange={ (event) => onChange && onChange(event.target.value) }
        />
    </>
}
