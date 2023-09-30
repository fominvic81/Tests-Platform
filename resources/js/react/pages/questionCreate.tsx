import React from 'react';
import { createRoot } from 'react-dom/client';
import { questionCreateComponentId } from '..';
import { QuestionEditComponent } from '../components/question-edit/QuestionEdit';

const Component: React.FC = () => {
    return <QuestionEditComponent></QuestionEditComponent>;
}

const root = createRoot(document.getElementById(questionCreateComponentId)!);
root.render(<Component></Component>);