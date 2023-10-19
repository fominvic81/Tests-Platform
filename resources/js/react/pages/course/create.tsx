import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { courseCreateId } from '../..';
import { Accessibility, AccessibilityName, Course, ValidationError } from '../../../api'; 
import { CSRF } from '../../utils';
import { FormTextInput } from '../../components/form/text';
import { FormError } from '../../components/form/error';
import { FormSubmit } from '../../components/form/submit';
import axios, { AxiosError } from 'axios';
import { FormImage } from '../../components/form/image';
import { TextEditor } from '../../components/TextEditor';
import { FormSelect } from '../../components/form/select';

const Component: React.FC = () => {

    const [error, setError] = useState<ValidationError>();

    const onSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const response = await axios.postForm('/api/course', event.target).catch((reason: AxiosError) => {
            if (reason.response && reason.response.status === 422) setError(reason.response.data as ValidationError);
        });
        if (!response) return;

        const course = response.data as Course<'tests' | 'user'>;
        location.replace(`/course/${course.id}/edit`);
    }

    return <>
        <div className='w-full p-4 bg-white border shadow-md'>
            <form className='w-full h-full' method='POST' onSubmit={ onSubmit }>
                <CSRF></CSRF>
                <h1 className='m-auto text-2xl w-min whitespace-nowrap'>Створити курс</h1>
                <div className='grid grid-cols-[1fr_auto] gap-3'>
                    <div>
                        <FormTextInput type='text' name='name' label='Назва' placeholder='Назва'></FormTextInput>
                        <label htmlFor='description'>Опис</label>
                        <TextEditor name='description' id="description" placeholder='Опис'></TextEditor>
                    </div>
                    <div className='w-40 h-40'>
                        <FormImage name='image' nameDel='delete_image'></FormImage>
                    </div>
                </div>
                <FormSelect name='accessibility' defaultValue={ Accessibility.Public } label='Доступність'>
                    {Object.values(Accessibility).filter((v) => typeof v !== 'number').map((key) =>
                        <option key={ key } value={ Accessibility[key] }>{ AccessibilityName[Accessibility[key]] }</option>
                    )}
                </FormSelect>
                <FormError error={ error }></FormError>
                <FormSubmit>Створити</FormSubmit>
            </form>
        </div>
    </>;
}

const root = createRoot(document.getElementById(courseCreateId)!);

root.render(
    <React.StrictMode>
        <Component></Component>
    </React.StrictMode>
);