import React, { useState } from 'react';
import { FormTextInput } from '../../form/text';
import { Question, QuestionType } from '../../../../api';

interface Props {
    question: Question<QuestionType.TextInput, false>;
}

export const TextInput: React.FC<Props> = ({ question }) => {

    const [text, setText] = useState(question.data.answer?.texts[0] ?? '');

    return <div>
        <FormTextInput type='text' name='answer[texts][0]' defaultValue={ text }></FormTextInput>
    </div>
}