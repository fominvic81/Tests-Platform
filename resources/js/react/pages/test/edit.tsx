import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { testEditId } from '../..';
import { Test, TestOptions, deleteQuestion, getTest, getTestOptions } from '../../../api'; 
import { QuestionEditComponent } from '../../components/question-edit/QuestionEdit';
import { QuestionComponent } from '../../components/question-show/Question';
import { Async, CSRF, Method, useAsync } from '../../utils';
import { FormTextInput } from '../../components/form/text';
import { FormSelect } from '../../components/form/select';
import { FormSubmit } from '../../components/form/submit';
import { useUrlState } from '../../hooks/useUrlState';

type AsyncData = [Test<'user'>, TestOptions];

type UrlData = {
    page: 'test' | 'quest-create' | 'quest-edit';
    editQuestionId: number;
}

const Component: React.FC = () => {

    const [test, options] = useAsync<AsyncData>();

    const [questions, setQuestions] = useState(test.questions);

    const [{ page, editQuestionId }, setUrlState] = useUrlState<UrlData>({
        page: 'test',
        editQuestionId: 0,
    });
    const questionToEdit = questions.find((q) => q.id === editQuestionId);

    return <>
        {page === 'test' && <>
            <div className='p-5 bg-white shadow-md'>
                <form action={ `/test/${test.id}` } method='POST'>
                    <CSRF></CSRF>
                    <Method method='PUT'></Method>
            
                    <FormTextInput type='text' name='name' label='Назва' placeholder='Назва' defaultValue={ test.name }></FormTextInput>
                    <FormTextInput type='text' name='description' label='Опис' placeholder='Опис' defaultValue={ test.description }></FormTextInput>

                    <FormSelect name='course' label='Курс' defaultValue={ test.course }>
                        <option className='font-bold' value='0'>Без курсу</option>
                        {options.courses.map((course) => 
                            <option key={ course.id } value={ course.id }>{ course.name }</option>                    
                        )}
                    </FormSelect>
            
                    <div className='grid grid-cols-2 gap-2'>
                        <div>
                            <FormSelect name='subject' label='Предмет' defaultValue={ test.subject }>
                                {options.subjects.map((subject) => 
                                    <option key={ subject.id } value={ subject.id }>{ subject.name }</option>
                                )}
                            </FormSelect>
                        </div>
                        <div>
                            <FormSelect name='grade' label='Клас' defaultValue={ test.grade }>
                                {options.grades.map((grade) =>
                                    <option key={ grade.id } value={ grade.id }>{ grade.name }</option>
                                )}
                            </FormSelect>
                        </div>
                    </div>

                    <FormSubmit>Зберегти</FormSubmit>
                </form>
            </div>

            <div>
                {questions.map((question, index) =>
                    <QuestionComponent
                        key={question.id}
                        question={question}
                        index={index}
                        onDelete={async () => {
                            if (await deleteQuestion(question.id)) {
                                setQuestions(questions.filter((q) => q.id !== question.id));
                            }
                        }}
                        onEdit={() => {
                            setUrlState({
                                page: 'quest-edit',
                                editQuestionId: question.id,
                            })
                        }}
                    ></QuestionComponent>
                )}
            </div>

            <button type='button' className='w-full text-2xl p-5 my-5 bg-gray-50 hover:bg-gray-100 border-2 border-gray-200' onClick={() => setUrlState({ page: 'quest-create' })}>Створити питання</button>
        </>}
        {page === 'quest-create' && <QuestionEditComponent
            onSave={(q) => {
                setUrlState({ page: 'test' });
                setQuestions([...questions, q]);
            }}
        ></QuestionEditComponent>}
        {page === 'quest-edit' && <QuestionEditComponent
            initialQuestion={ questionToEdit }
            onSave={(q) => {
                setUrlState({ page: 'test', editQuestionId: undefined });
                setQuestions(questions.map((question) => question.id === editQuestionId ? q : question));
            }}
        ></QuestionEditComponent>}
    </>;
}

const root = createRoot(document.getElementById(testEditId)!);

root.render(
    <React.StrictMode>
        <Async loader={() => Promise.all([getTest(location.pathname.split('/')[2]), getTestOptions()])}>
            <Component></Component>
        </Async>
    </React.StrictMode>
);