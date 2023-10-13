import React, { useState } from 'react';
import { OptionByType, QuestionType } from '../../../api';
import { FormTextInput } from '../form/input';

interface Props {
    initialOptions: OptionByType<QuestionType.Match>[];
}

export const Match: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    const onChangeValue = <T extends keyof OptionByType<QuestionType.OneCorrect>>(index: number, key: T, value: OptionByType<QuestionType.OneCorrect>[T]) => {
        const newOption = { ...options[index], [key]: value};
        setOptions(options.map((option, i) => i === index ? newOption : option));
    }
    console.log(initialOptions);

    const left = initialOptions.filter((option) => !Number.isInteger(option.match_id));
    const right = initialOptions.filter((option) => Number.isInteger(option.match_id));

    return <div className='grid grid-cols-2 gap-2'>
        <div>
            { left.map((option, index) => <React.Fragment key={ index }>
                <input type='hidden' name={ `options[${index}][id]` } value={ option.id } />
                123
            </React.Fragment>)}
        </div>
        <div>
            { right.map((option, index) => <React.Fragment key={ index }>
                <input type='hidden' name={ `options[${index}][id]` } value={ option.id } />
                123
            </React.Fragment>)}
        </div>
    </div>
}