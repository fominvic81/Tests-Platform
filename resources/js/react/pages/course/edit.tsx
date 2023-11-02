import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { courseEditId } from '../..';
import { Accessibility, AccessibilityName, Course, ValidationError, imagePath, getCourse } from '../../../api'; 
import { Async, CSRF, Method, useAsync } from '../../utils';
import { FormTextInput } from '../../components/form/text';
import { FormError } from '../../components/form/error';
import { FormSubmit } from '../../components/form/submit';
import axios, { AxiosError } from 'axios';
import { FormImage } from '../../components/form/image';
import { TextEditor } from '../../components/TextEditor';
import { FormSelect } from '../../components/form/select';

type AsyncData = [Course];

const Component: React.FC = () => {

    const [course] = useAsync<AsyncData>();
    const [error, setError] = useState<ValidationError>();

    const onSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const response = await axios.postForm(`/api/course/${course.id}`, event.target).catch((reason: AxiosError) => {
            if (reason.response && reason.response.status === 422) setError(reason.response.data as ValidationError);
        });
        if (!response) return;

        setError(undefined);
        location.href = `/course/${course.id}`;
    }

    return <>
        <div className='w-full p-4 bg-white border shadow-md font-semibold'>
            <form className='w-full h-full' onSubmit={ onSubmit }>
                <CSRF></CSRF>
                <Method method='PUT'></Method>

                <div className='grid grid-cols-[1fr_auto] gap-3'>
                    <div>
                        <FormTextInput type='text' name='name' label='Назва' placeholder='Назва' defaultValue={ course.name }></FormTextInput>

                        <label htmlFor='description'>Опис</label>
                        <TextEditor name='description' id="description" placeholder='Опис' defaultValue={ course.description }></TextEditor>
                    </div>
                    <div className='w-40 h-40'>
                        <FormImage name='image' nameDel='del_image' defaultSrc={ course.image && imagePath(course.image) }></FormImage>
                    </div>
                </div>
                <FormSelect name='accessibility' defaultValue={ course.accessibility } label='Доступність'>
                    {Object.values(Accessibility).filter((v) => typeof v !== 'number').map((key) =>
                        <option key={ key } value={ Accessibility[key] }>{ AccessibilityName[Accessibility[key]] }</option>
                    )}
                </FormSelect>
                <FormError error={ error }></FormError>
                <FormSubmit>Зберегти</FormSubmit>
            </form>
        </div>
    </>;
}

const root = createRoot(document.getElementById(courseEditId)!);

root.render(
    <React.StrictMode>
        <Async loader={() => Promise.all([getCourse(location.pathname.split('/')[2])])}>
            <Component></Component>
        </Async>
    </React.StrictMode>
);