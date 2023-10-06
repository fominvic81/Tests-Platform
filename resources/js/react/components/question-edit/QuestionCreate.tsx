// import React from 'react';
// import { QuestionEditComponent } from './QuestionEdit';
// import { Question, QuestionType, QuestionTypeInitialData } from '../../../api';

// const defaultQuestion: Question = {
//     id: 0,
//     type: QuestionType.OneCorrect,
//     text: '',
//     data: QuestionTypeInitialData[QuestionType.OneCorrect],
//     points: 1,
//     topics: [],
// };

// interface Props {
//     onCreate: (question: Question) => any;
// }

// export const QuestionCreateComponent: React.FC<Props> = ({ onCreate }) => {

//     return <QuestionEditComponent initialQuestion={defaultQuestion} onSave={onCreate}></QuestionEditComponent>
// }