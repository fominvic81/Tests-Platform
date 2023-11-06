import React, { useId, useState } from 'react';
import cn from 'classnames';

interface Props {
    name: string;
    label?: string;
    checked?: boolean;
    defaultChecked?: boolean;
    onChange?: (value: boolean) => any;
}

export const FormToggle: React.FC<Props> = ({ name, checked, defaultChecked, onChange: onChangeEvent, label }) => {
    const [value, setValue] = useState(defaultChecked ?? checked ?? false);

    const onChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const newValue = event.target.checked;
        setValue(newValue);
        if (onChangeEvent) onChangeEvent(newValue);
    }

    return <div>
        <input type='hidden' name={ name } value={ value ? 1 : 0 } />
        <label className='flex items-center my-1'>
            <input className='w-0 h-0 m-0 p-0 peer' type='checkbox' checked={ value } onChange={onChange} />
            <div className={cn('w-[52px] p-1 mr-1 rounded-full peer-focus-visible:outline border-2 transition-all', value ? 'border-yellow-400' : 'border-gray-500')}>
                <div className={cn('flex justify-end h-5 transition-all', value ? 'w-full' : 'w-5')}>
                    <div className={cn('h-full aspect-square rounded-full transition-all', value ? 'bg-yellow-400' : 'bg-gray-500')}></div>
                </div>
            </div>
            { label }
        </label>
    </div>
}