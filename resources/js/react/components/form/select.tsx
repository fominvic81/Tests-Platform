import React, { PropsWithChildren, useId } from 'react';

interface Props extends PropsWithChildren {
    name: string;
    label?: string;
    defaultValue?: any;
    value?: any;
    onChange?: (value: any) => any;
}

export const FormSelect: React.FC<Props> = ({ name, defaultValue, value, onChange, label, children }) => {

    return <div>
        {label && <label htmlFor={ name }>{ label }</label>}
        <select
            className='w-full p-1 border-2 rounded'
            name={ name }
            id={ name }
            defaultValue={ defaultValue }
            value={ value }
            onChange={(event) => onChange && onChange(event.target.value)}
        >{ children }</select>
    </div>
}