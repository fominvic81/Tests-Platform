import React, { PropsWithChildren, useId } from 'react';

interface Props extends PropsWithChildren {
    name: string;
    label?: string;
    defaultValue?: any;
    value?: any;
    onChange?: (value: any) => any;
}

export const FormSelect: React.FC<Props> = ({ name, defaultValue, value, onChange, label, children }) => {
    const id = `${name}-${useId()}`;

    return <>
        {label && <label htmlFor={ id }>{ label }</label>}
        <select
            className='block bg-gray-50 w-full p-1 border border-gray-300'
            name={ name }
            id={ id }
            defaultValue={ defaultValue }
            value={ value }
            onChange={(event) => onChange && onChange(event.target.value)}
        >{ children }</select>
    </>
}