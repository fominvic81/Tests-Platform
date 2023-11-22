import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { testEditId } from '../..';
import { Accessibility, AccessibilityName, Test, TestOptions, ValidationError, deleteQuestion, getTest, getTestOptions, imagePath } from '../../../api'; 
import { QuestionEdit } from '../../components/question/edit';
import { QuestionShow } from '../../components/question/show';
import { Async, CSRF, Method, useAsync } from '../../utils';
import { FormTextInput } from '../../components/form/text';
import { FormSelect } from '../../components/form/select';
import { FormSubmit } from '../../components/form/submit';
import { useUrlState } from '../../hooks/useUrlState';
import { FormImage } from '../../components/form/image';
import axios, { AxiosError } from 'axios';
import { FormError } from '../../components/form/error';
import { TextEditor } from '../../components/TextEditor';
import { ImageContain } from '../../components/common/ImageContain';

import EditSVG from '../../../../svg/common/edit.svg?react';

type AsyncData = [Test<'course' | 'questions'>, TestOptions];

type UrlData = {
    page: 'test' | 'quest-create' | 'quest-edit';
    editQuestionId: number;
}

const Component: React.FC = () => {

    const [initTest, options] = useAsync<AsyncData>();
    const [test, setTest] = useState(initTest);
    const [error, setError] = useState<ValidationError>();
    const [showForm, setShowForm] = useState(false);

    const [questions, setQuestions] = useState(test.questions);

    const [{ page, editQuestionId }, setUrlState] = useUrlState<UrlData>({
        page: 'test',
        editQuestionId: 0,
    });
    const questionToEdit = questions.find((q) => q.id === editQuestionId);

    const onSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const response = await axios.postForm(`/api/test/${test.id}`, event.target).catch((reason: AxiosError) => {
            if (reason.response && reason.response.status === 422) setError(reason.response.data as ValidationError);
        });
        if (!response) return;

        setTest(response.data);
        setShowForm(false);
        setError(undefined);
    }

    return <>
        {page === 'test' && <>
            {showForm && <div onMouseDown={() => setShowForm(false)} className='flex justify-center items-start fixed top-0 left-0 w-full h-full bg-gray-600 bg-opacity-30'>
                <div onMouseDown={(event) => event.stopPropagation()} className='p-5 mt-24 bg-white rounded-lg font-semibold'>
                    <form onSubmit={ onSubmit }>
                        <CSRF></CSRF>
                        <Method method='PUT'></Method>
                
                        <div className='grid grid-cols-[1fr_min-content]'>
                            <div>
                                <FormTextInput type='text' name='name' label='Назва' placeholder='Назва' defaultValue={ test.name }></FormTextInput>

                                <label htmlFor='description'>Опис</label>
                                <TextEditor id='description' name='description' placeholder='Опис' defaultValue={ test.description }></TextEditor>
                            </div>
                            <div className='w-40 h-40 m-3'>
                                <FormImage name='image' nameDel='del_image' defaultSrc={ test.image && imagePath(test.image) }></FormImage>
                            </div>
                        </div>
                
                        <div className='grid grid-cols-2 gap-x-3'>
                            <FormSelect name='course' label='Курс' defaultValue={ test.course?.id }>
                                <option className='font-bold' value=''>Без курсу</option>
                                {options.courses.map((course) => 
                                    <option key={ course.id } value={ course.id }>{ course.name }</option>                    
                                )}
                            </FormSelect>
                            <FormSelect name='accessibility' defaultValue={ test.accessibility } label='Доступність'>
                                {Object.values(Accessibility).filter((v) => typeof v !== 'number').map((key) =>
                                    <option key={ key } value={ Accessibility[key] }>{ AccessibilityName[Accessibility[key]] }</option>
                                )}
                            </FormSelect>
                            <FormSelect name='subject' label='Предмет' defaultValue={ test.subject?.id }>
                                <option value="">...</option>
                                {options.subjects.map((subject) => 
                                    <option key={ subject.id } value={ subject.id }>{ subject.name }</option>
                                )}
                            </FormSelect>
                            <FormSelect name='grade' label='Клас' defaultValue={ test.grade?.id }>
                                <option value="">...</option>
                                {options.grades.map((grade) =>
                                    <option key={ grade.id } value={ grade.id }>{ grade.name }</option>
                                )}
                            </FormSelect>
                        </div>
                        <div className='mt-2'>
                            <FormSubmit>Зберегти</FormSubmit>
                            <FormError error={ error }></FormError>
                        </div>
                    </form>
                </div> 
            </div>}
            <div className='p-5 my-2 bg-white shadow-md rounded-md'>
                <div className='grid grid-cols-[min-content_1fr_auto]'>
                    <div>
                        {test.image && <ImageContain src={ imagePath(test.image) }></ImageContain>}
                    </div>
                    <div>
                        <div className='text-2xl'>{ test.name }</div>
                        <div>
                            { test.subject?.name } { test.grade?.name }
                        </div>
                        <div>{AccessibilityName[test.accessibility]}</div>
                        {test.course && <div>Курс:
                            <a
                                href={`/course/${test.course.id}`}
                                className='text-blue-600 hover:text-blue-300 hover:underline'
                            >{ test.course?.name }</a>
                        </div>}
                    </div>
                    <div className='flex gap-2'>
                        <button
                            className='w-9 h-9 border-2 rounded-md'
                            onClick={ () => setShowForm(true) }
                        ><EditSVG></EditSVG></button>
                        {!test.published && <form action={`/test/${test.id}/publish`} method='POST'>
                            <CSRF></CSRF>
                            <button className='flex items-center h-9 bg-yellow-300 p-2 rounded border-2'>Опублікувати</button>
                        </form>}
                    </div>
                    <div className='col-span-full' dangerouslySetInnerHTML={{ __html: test.description ?? '' }}></div>
                </div>
            </div>

            <div>
                {questions.map((question, index) =>
                    <QuestionShow
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
                    ></QuestionShow>
                )}
            </div>
            <button
                type='button'
                className='w-full text-2xl p-5 mt-2 bg-white hover:bg-gray-50 border-2 rounded-md shadow-md'
                onClick={() => setUrlState({ page: 'quest-create' })}
            >Створити питання</button>
        </>}
        {page === 'quest-create' && <QuestionEdit
            onSave={(q) => {
                setUrlState({ page: 'test' });
                setQuestions([...questions, q]);
            }}
        ></QuestionEdit>}
        {page === 'quest-edit' && <QuestionEdit
            initialQuestion={ questionToEdit }
            onSave={(q) => {
                setUrlState({ page: 'test', editQuestionId: undefined });
                setQuestions(questions.map((question) => question.id === editQuestionId ? q : question));
            }}
        ></QuestionEdit>}
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