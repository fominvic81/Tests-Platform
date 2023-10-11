import React, { useId, useState } from 'react';
import cn from 'classnames';

interface Props {
    name: string;
    label?: string;
    checked?: boolean;
    defaultChecked?: boolean;
    onChange?: (value: boolean) => any;
}

export const FormToggle: React.FC<Props> = ({ name, checked, defaultChecked, onChange, label }) => {
    const id = `${name}-${useId()}`
    const [value, setValue] = useState(defaultChecked ?? checked ?? false);

    return <>
        {/* {label && <label htmlFor={ id }>{ label }</label>} */}
        <label htmlFor={ id } className='flex items-center my-1'>
            <div className={cn('w-12 p-1 mr-1 border border-gray-400 rounded-full transition-colors', value ? 'bg-yellow-300' : 'bg-gray-200')}>
                <div className={cn('flex justify-end h-5 transition-all', value ? 'w-full' : 'w-5')}>
                    <div className={'h-full aspect-square rounded-full bg-gray-300 bg-opacity-250 border border-gray-500'}></div>
                </div>
            </div>
            { label }
        </label>
        <input
            type='hidden'
            name={ name }
            value={ value ? 1 : 0 }
        />
        <input
            className='hidden'
            type='checkbox'
            id={ id }
            checked={ value }
            onChange={(event) => {
                const newValue = event.target.checked;
                setValue(newValue);
                if (onChange) onChange(newValue);
            }}
        />
    </>
}