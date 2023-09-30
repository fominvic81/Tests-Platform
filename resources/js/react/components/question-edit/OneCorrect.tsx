import React from 'react';
import { Question, QuestionType } from '../../../api';


interface Props {
    type: QuestionType.OneCorrect;
}

export const QuestionOneCorrect: React.FC<Props> = ({ type }) => {
    return type;
}