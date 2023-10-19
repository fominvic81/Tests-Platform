import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { testCreateId } from '../..';
import { Accessibility, AccessibilityName, Test, TestOptions, ValidationError, getTestOptions } from '../../../api'; 
import { Async, CSRF, useAsync } from '../../utils';
import { FormTextInput } from '../../components/form/text';
import { FormSelect } from '../../components/form/select';
import { FormError } from '../../components/form/error';
import { FormSubmit } from '../../components/form/submit';
import axios, { AxiosError } from 'axios';
import { FormImage } from '../../components/form/image';
import { TextEditor } from '../../components/TextEditor';

type AsyncData = [TestOptions];

const Component: React.FC = () => {

    const [options] = useAsync<AsyncData>();
    const [error, setError] = useState<ValidationError>();

    const onSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const response = await axios.postForm('/api/test', event.target).catch((reason: AxiosError) => {
            if (reason.response && reason.response.status === 422) setError(reason.response.data as ValidationError);
        });
        if (!response) return;

        const test = response.data as Test;
        location.replace(`/test/${test.id}/edit`);
    }

    return <>
        <div className='w-full p-4 bg-white border shadow-md'>
            <form className='w-full h-full' method='POST' onSubmit={ onSubmit }>
                <CSRF></CSRF>
                <h1 className='m-auto text-2xl w-min whitespace-nowrap'>Створити тест</h1>
                <div className='grid grid-cols-[1fr_auto] gap-3 items-center'>
                    <div>
                        <FormTextInput type='text' name='name' label='Назва' placeholder='Назва'></FormTextInput>
                        
                        <label htmlFor='description'>Опис</label>
                        <TextEditor name='description' id="description" placeholder='Опис'></TextEditor>
                    </div>
                    <div className='w-40 h-40'>
                        <FormImage name='image' nameDel='delete_image'></FormImage>
                    </div>
                </div>
                <div className='grid grid-cols-2 gap-3'>
                    <div>
                        <FormSelect name='course' label='Виберіть курс' defaultValue={ new URLSearchParams(location.search).get('course') }>
                            <option className='font-bold' value='0'>Без курсу</option>
                            {options.courses.map((course) =>
                                <option key={ course.id } value={ course.id }>{ course.name }</option>
                            )}
                        </FormSelect>
                    </div>
                    <div>
                        <FormSelect name='accessibility' defaultValue={ Accessibility.Public } label='Доступність'>
                            {Object.values(Accessibility).filter((v) => typeof v !== 'number').map((key) =>
                                <option key={ key } value={ Accessibility[key] }>{ AccessibilityName[Accessibility[key]] }</option>
                            )}
                        </FormSelect>
                    </div>
                    <div>
                        <FormSelect name='subject' label='Предмет'>
                            {options.subjects.map((subject) => 
                                <option key={ subject.id } value={ subject.id }>{ subject.name }</option>
                            )}
                        </FormSelect>
                    </div>
                    <div>
                        <FormSelect name='grade' label='Клас'>
                            {options.grades.map((grade) => 
                                <option key={ grade.id } value={ grade.id }>{ grade.name }</option>
                            )}
                        </FormSelect>
                    </div>
                </div>
                <FormError error={ error }></FormError>
                <FormSubmit>Створити</FormSubmit>
            </form>
        </div>
    </>;
}

const root = createRoot(document.getElementById(testCreateId)!);

root.render(
    <React.StrictMode>
        <Async loader={() => Promise.all([getTestOptions()])}>
            <Component></Component>
        </Async>
    </React.StrictMode>
);