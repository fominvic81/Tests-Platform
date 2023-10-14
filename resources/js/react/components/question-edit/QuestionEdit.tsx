import React, { useEffect, useState } from 'react';
import { Question, QuestionType, OptionsInitialData, QuestionTypeName, ValidationError } from '../../../api';
import { OneCorrect } from './OneCorrect';
import { CSRF, Method } from '../../utils';
import { TextEditor } from '../TextEditor';
import { FormTextInput } from '../form/input';
import { FormTextarea } from '../form/textarea';
import { FormSubmit } from '../form/submit';
import axios, { AxiosError } from 'axios';
import { FormError } from '../form/error';
import { useUrlState } from '../../hooks/useUrlState';
import { MultipleCorrect } from './MultipleCorrect';
import { FormToggle } from '../form/toggle';
import { Match } from './Match';
import cn from 'classnames';

const questionComponentByType: Record<QuestionType, React.FC<any>> = {
    [QuestionType.OneCorrect]: OneCorrect,
    [QuestionType.MultipleCorrect]: MultipleCorrect,
    [QuestionType.Match]: Match,
    [QuestionType.TextInput]: () => <></>,
    [QuestionType.Sequense]: () => <></>,
    [QuestionType.TextGapsTextInput]: () => <></>,
    [QuestionType.TextGapsVariantSingleList]: () => <></>,
    [QuestionType.TextGapsVariantMultipleLists]: () => <></>,
} as const;

const defaultQuestion: Question = {
    id: 0,
    type: QuestionType.OneCorrect,
    text: '',
    options: OptionsInitialData[QuestionType.OneCorrect],
    points: 1,
    topics: [],
    register_matters: false,
    whitespace_matters: false,
    show_amount_of_correct: false,
};

type UrlData = {
    type: QuestionType;
}

interface Props {
    initialQuestion?: Question;
    onSave: (question: Question) => any;
    onCancel: () => any;
}

export const QuestionEditComponent: React.FC<Props> = ({ initialQuestion, onSave, onCancel }) => {

    const create = !initialQuestion;
    const action = create ? `/api/test/${location.pathname.split('/')[2]}/question` : `/api/question/${initialQuestion.id}`;
    const method = create ? 'POST' : 'PUT';

    const [question, setQuestion] = useState(initialQuestion ?? defaultQuestion);

    const [{ type }, setUrlData, resetUrlData] = useUrlState<UrlData>({ type: question.type });
    const [error, setError] = useState<ValidationError>();

    const setType = (newType: QuestionType) => {
        setQuestion({ ...question, options: OptionsInitialData[newType]});
        setUrlData({ type: newType }, true);
    }

    const Component = questionComponentByType[type];

    const onSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const response = await axios.postForm(action, event.target).catch((reason: AxiosError) => {
            if (reason.response && reason.response.status === 422) setError(reason.response.data as ValidationError);
        });
        if (!response) return;

        resetUrlData(true);

        onSave(response.data);
    }

    return <div className='bg-white border shadow-md p-4 mb-10'>
        <form action={action} method='POST' encType='multipart/form-data' onSubmit={onSubmit}>
            <CSRF></CSRF>
            <Method method={method}></Method>
            <input type='hidden' name='type' value={ type } />
            <div className='grid grid-cols-[auto_1fr] gap-4'>
                <div>
                    { Object.values(QuestionType).filter((v) => typeof v !== 'number').map((key) => 
                        <button
                            type='button'
                            key={key}
                            className={cn('block w-full p-1 my-2 hover:brightness-90 rounded', type === QuestionType[key] ? 'bg-sky-400' : 'bg-emerald-400 ')}
                            onClick={() => setType(QuestionType[key])}
                        >{ QuestionTypeName[QuestionType[key]] }</button>
                    )}
                </div>
                <div>
                    <div className='text-2xl indent-1'>{ create ? 'Створити' : 'Редагувати' } питання</div>
                    <div className='grid grid-cols-[1fr_auto] p-2 border-2'>
                        <div className='overflow-hidden'>
                            <label htmlFor='text'>Питання</label>
                            <TextEditor name='text' id='text' defaultValue={ question.text } placeholder='Питання'></TextEditor>
                        </div>
                        <div className='w-48 row-span-6'>
                            <div className={`aspect-square mx-3 mt-6 border-2 ${!question.image ? 'border-dashed' : ''}`}>
                                <label htmlFor='image-upload' className='w-full h-full relative flex items-center justify-center'>
                                    <img className='max-w-full max-h-full' src={ question.image ?? '/images/add-image.png' } alt='Зоображення' />
                                    <div className='absolute w-full py-2 text-center bottom-0 bg-gray-200 bg-opacity-40 border-t'>{question.image ? 'Видалити' : 'Додати зображення'}</div>
                                </label>
                                <input
                                    type='file'
                                    name='image'
                                    id='image-upload'
                                    accept='image/*'
                                    className='hidden'
                                    onClick={(event) => {
                                        if (question.image) {
                                            event.preventDefault();
                                            setQuestion({ ...question, image: undefined });
                                            
                                            event.currentTarget.value = '';
                                        }
                                    }}
                                    onChange={(event) => {
                                        const file = event.target.files?.item(0);
                                        
                                        if (file) setQuestion({ ...question, image: URL.createObjectURL(file) });
                                    }}
                                />
                            </div>
                        </div>
                        <div>
                            <FormTextarea name='description' label='Опис' placeholder='Опис' />
                        </div>
                        <div>
                            <FormTextInput type='number' name='points' label='Бали' defaultValue={question?.points ?? 1} placeholder='Кількість балів'></FormTextInput>
                        </div>

                        { type === QuestionType.TextInput && <FormToggle defaultChecked={ question.register_matters ?? false } name='register_matters' label='Враховувати пробіл'></FormToggle> }
                        { type === QuestionType.TextInput && <FormToggle defaultChecked={ question.whitespace_matters ?? false } name='whitespace_matters' label='Враховувати розмір букви'></FormToggle> }
                        { type === QuestionType.MultipleCorrect && <FormToggle defaultChecked={ question.show_amount_of_correct ?? false } name='show_amount_of_correct' label='Показувати кількість правильних варіантів'></FormToggle> }
                    </div>
                    
                </div>
            </div>
            <div className='mt-1 p-2 border-2'>
                <Component initialOptions={ question.options }></Component>
            </div>
            <div className='grid grid-cols-2 items-baseline gap-2'>
                <button
                    type='button'
                    className='h-10 bg-gray-50 border rounded'
                    onClick={() => {
                        resetUrlData();
                        onCancel();
                    }}
                >Назад</button>
                <FormSubmit>{ create ? 'Створити' : 'Зберегти' }</FormSubmit>
            </div>
            <FormError error={error}></FormError>
        </form>
    </div>
}