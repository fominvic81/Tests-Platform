import React, { useState } from 'react';
import { OptionByType, QuestionType } from '../../../api';
import { FormTextInput } from '../form/input';
import { Option } from './Option';

interface Props {
    initialOptions: OptionByType<QuestionType.Match>[];
}

export const Match: React.FC<Props> = ({ initialOptions }) => {

    const [options, setOptions] = useState(initialOptions);

    // const onChangeValue = <T extends keyof OptionByType<QuestionType.OneCorrect>>(index: number, key: T, value: OptionByType<QuestionType.OneCorrect>[T]) => {
    //     const newOption = { ...options[index], [key]: value};
    //     setOptions(options.map((option, i) => i === index ? newOption : option));
    // }

    const left = initialOptions.filter((option) => !Number.isInteger(option.match_id));
    const right = initialOptions.filter((option) => Number.isInteger(option.match_id));

    return <div className='grid grid-cols-2 gap-2'>
        <div className='grid gap-2'>
            { left.map((option, index) => <React.Fragment key={ index }>
                <Option
                    index={ index }
                    option={ option }
                    deletable={ options.length > 2 }
                    onDelete={() => {
                        setOptions([...options.filter((o, idx) => idx !== index)]);
                    }}
                ></Option>
            </React.Fragment>)}
        </div>
        <div className='grid gap-2'>
            { right.map((option, index) => <React.Fragment key={ index }>
                <Option
                    index={ index }
                    option={ option }
                    deletable={ options.length > 2 }
                    onDelete={() => {
                        setOptions([...options.filter((o, idx) => idx !== index)]);
                    }}
                ></Option>
            </React.Fragment>)}
        </div>
    </div>
}