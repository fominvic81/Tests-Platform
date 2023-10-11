import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { testEditorId } from '..';
import { Test, TestOptions, deleteQuestion, getTest, getTestOptions } from '../../api'; 
import { QuestionEditComponent } from '../components/question-edit/QuestionEdit';
import { QuestionComponent } from '../components/question/Question';
import { Async, CSRF, Method, useAsync } from '../utils';
import { FormTextInput } from '../components/form/input';
import { FormSelect } from '../components/form/select';
import { FormSubmit } from '../components/form/submit';
import { useUrlState } from '../hooks/useUrlState';

type AsyncData = [Test<'user'>, TestOptions];

type UrlData = {
    page: 'editor' | 'create' | 'edit';
    editQuestionId: number;
}

const TestEditor: React.FC = () => {

    const [test, options] = useAsync<AsyncData>();

    const [name, setName] = useState(test.name);
    const [description, setDescription] = useState(test.description ?? '');
    const [course, setCourse] = useState(test.course?.id ?? 0);
    const [subject, setSubject] = useState(test.subject?.id ?? 0);
    const [grade, setGrade] = useState(test.grade?.id ?? 0);
    const [questions, setQuestions] = useState(test.questions);

    const [{ page, editQuestionId }, setUrlState] = useUrlState<UrlData>({
        page: 'editor',
        editQuestionId: 0,
    });
    const questionToEdit = questions.find((q) => q.id === editQuestionId);

    return <>
        {page === 'editor' && <>
            <div className='p-5 bg-white shadow-md'>
                <form action={ `/test/${test.id}` } method='POST'>
                    <CSRF></CSRF>
                    <Method method='PUT'></Method>
            
                    <FormTextInput type='text' name='name' label='Назва' placeholder='Назва' value={ name } onChange={ setName }></FormTextInput>
                    <FormTextInput type='text' name='description' label='Опис' placeholder='Опис' value={ description } onChange={ setDescription }></FormTextInput>

                    <FormSelect name='course' label='Курс' value={ course } onChange={ setCourse }>
                        <option className='font-bold' value='0'>Без курсу</option>
                        {options.courses.map((course) => 
                            <option key={ course.id } value={ course.id }>{ course.name }</option>                    
                        )}
                    </FormSelect>
            
                    <div className='grid grid-cols-2 gap-2'>
                        <div>
                            <FormSelect name='subject' label='Предмет' value={ subject } onChange={ setSubject }>
                                {options.subjects.map((subject) => 
                                    <option key={ subject.id } value={ subject.id }>{ subject.name }</option>
                                )}
                            </FormSelect>
                        </div>
                        <div>
                            <FormSelect name='grade' label='Клас' value={ grade } onChange={ setGrade }>
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
                                page: 'edit',
                                editQuestionId: question.id,
                            })
                        }}
                    ></QuestionComponent>
                )}
            </div>

            <button type='button' className='w-full text-2xl p-5 mb-5 bg-gray-50 hover:bg-gray-100 border-2 border-gray-200' onClick={() => setUrlState({ page: 'create' })}>Створити питання</button>
        </>}
        {page === 'create' && <QuestionEditComponent onSave={(q) => {
            setUrlState({ page: 'editor' });
            setQuestions([...questions, q]);
        }}></QuestionEditComponent>}
        {page === 'edit' && <QuestionEditComponent initialQuestion={questionToEdit} onSave={(q) => {
            setUrlState({ page: 'editor', editQuestionId: undefined });
            setQuestions(questions.map((question) => question.id === editQuestionId ? q : question));
        }}></QuestionEditComponent>}
    </>;
}

const root = createRoot(document.getElementById(testEditorId)!);

root.render(
    <React.StrictMode>
        <Async loader={() => Promise.all([getTest(181), getTestOptions()])}>
            <TestEditor></TestEditor>
        </Async>
    </React.StrictMode>
);