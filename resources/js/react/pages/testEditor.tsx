import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { createBrowserRouter, RouterProvider, Route, useLoaderData, useParams, Outlet } from 'react-router-dom';
import { testEditorId } from '..';
import { Course, Question, Test, TestOptions, getTest, getTestOptions } from '../../api'; 
import { QuestionComponent } from '../components/question/Question';

interface LoaderData {
    test: Test<'questions' & 'course'>;
    options: TestOptions;
}

const Editor: React.FC = () => {

    const { test, options } = useLoaderData() as LoaderData;
    const [name, setName] = useState(test.name);
    const [description, setDescription] = useState(test.description ?? '');
    const [course, setCourse] = useState(test.course?.id ?? 0);
    const [subject, setSubject] = useState(test.subject?.id ?? 0);
    const [grade, setGrade] = useState(test.grade?.id ?? 0);

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')!;

    return <>
        <div className='p-5 bg-white shadow-md'>
            <form action={`/test/${test.id}`} method='POST'>
                <input type='hidden' name='_token' value={ csrf } />
                <input type='hidden' name='_method' value='put' />

                <label htmlFor='name'>Назва</label>
                <input className='w-full text-2xl border p-1' name='name' id='name' type='text' value={ name } onChange={(event) => setName(event.target.value)} />

                <label htmlFor='description'>Опис</label>
                <textarea className='w-full border p-1' name='description' id='description' value={ description } onChange={(event) => setDescription(event.target.value)} />

                <label htmlFor='course'>Курс</label>
                <select className='w-full border border-gray-300 p-1' name='course' id='course' value={ course } onChange={(event) => setCourse(parseInt(event.target.value))}>
                    <option value='0'>Без курсу</option>
                    {options.courses.map((course) => <option key={ course.id } value={ course.id }>{ course.name }</option>)}
                </select>

                <div className='grid grid-cols-2 gap-2'>
                    <div>
                        <label htmlFor='subject'>Предмет</label>
                        <select className='w-full border border-gray-300 p-1' name='subject' id='subject' value={ subject } onChange={(event) => setSubject(parseInt(event.target.value))}>
                            {options.subjects.map((subject) => <option key={ subject.id } value={ subject.id }>{ subject.name }</option>)}
                        </select>
                    </div>
                    <div>
                        <label htmlFor='grade'>Клас</label>
                        <select className='w-full border border-gray-300 p-1' name='grade' id='grade' value={ grade } onChange={(event) => setGrade(parseInt(event.target.value))}>
                            {options.grades.map((grade) => <option key={ grade.id } value={ grade.id }>{ grade.name }</option>)}
                        </select>
                    </div>
                </div>

                <button className='w-full h-10 mt-5 bg-sky-500 border border-blue-400 rounded' type='submit'>Зберегти</button>
            </form>
        </div>

        <div>
            {test.questions.map((question, index) => <QuestionComponent key={question.id} question={question} index={index}></QuestionComponent>)}
        </div>
    </>;
}

const router = createBrowserRouter([
    {
        path: '/test/:testId/edit',
        element: <Editor></Editor>,
        loader: async ({ params }) => {
            const data: LoaderData = {
                test: await getTest(params.testId!),
                options: await getTestOptions(),
            }
            return data;
        },
        children: [{
            path: 'new',
            element: <div>123</div>,
        }],
    },
])

const root = createRoot(document.getElementById(testEditorId)!);

root.render(
    <React.StrictMode>
        <RouterProvider router={router}></RouterProvider>
    </React.StrictMode>
);
