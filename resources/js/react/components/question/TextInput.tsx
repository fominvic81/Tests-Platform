import React from 'react';
import { OptionByType, QuestionType } from '../../../api';

interface Props {
    options: OptionByType<QuestionType.TextInput>[];
}

export const TextInput: React.FC<Props> = ({ options }) => {
    return <div>
        {options.map((option) => 
            <div key={ option.id } className='my-2 border-l-4 pl-2'>{ option.text }</div>
        )}
    </div>
}