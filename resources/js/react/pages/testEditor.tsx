import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { createBrowserRouter, Link, RouterProvider, useRouteLoaderData } from 'react-router-dom';
import { testEditorId } from '..';
import { Test, TestOptions, deleteQuestion, getTest, getTestOptions } from '../../api'; 
import { QuestionEditComponent } from '../components/question-edit/QuestionEdit';
import { QuestionComponent } from '../components/question/Question';
import { CSRF, Method } from '../utils';
import { FormTextInput } from '../components/form/input';
import { FormSelect } from '../components/form/select';
import { FormSubmit } from '../components/form/submit';

interface LoaderData {
    test: Test<'questions' & 'course'>;
    options: TestOptions;
}


const TestEditor: React.FC = () => {

    const { test, options } = useRouteLoaderData('root') as LoaderData;
    const [name, setName] = useState(test.name);
    const [description, setDescription] = useState(test.description ?? '');
    const [course, setCourse] = useState(test.course?.id ?? 0);
    const [subject, setSubject] = useState(test.subject?.id ?? 0);
    const [grade, setGrade] = useState(test.grade?.id ?? 0);
    const [questions, setQuestions] = useState(test.questions);

    return <>
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
                ></QuestionComponent>
            )}
        </div>

        <Link to='../question/create' className='flex justify-center items-center text-2xl p-5 mb-5 bg-gray-50 hover:bg-gray-100 border-2 border-gray-200'>Створити питання</Link>
    </>;
}

const router = createBrowserRouter([
    {
        path: '/test/:testId',
        id: 'root',
        loader: async ({ params }) => {
            const [ test, options ] = await Promise.all([getTest(params.testId!), getTestOptions()]);
            const data: LoaderData = { test, options };
            return data;
        },
        children: [
            {
                path: 'edit',
                element: <TestEditor></TestEditor>,
            },
            {
                path: 'question/create',
                element: <QuestionEditComponent></QuestionEditComponent>,
            },
        ],
    },
])

const root = createRoot(document.getElementById(testEditorId)!);

root.render(
    <React.StrictMode>
        <RouterProvider router={router}></RouterProvider>
    </React.StrictMode>
);