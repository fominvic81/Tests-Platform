import React, { useState } from 'react';
import { Question, QuestionType, OptionsInitialData, QuestionTypeName, ValidationError } from '../../../api';
import { QuestionOneCorrect } from './OneCorrect';
import { CSRF, Method } from '../../utils';
import { EditorComponent } from '../Editor';
import { FormTextInput } from '../form/input';
import { FormTextarea } from '../form/textarea';
import { FormSubmit } from '../form/submit';
import axios, { AxiosError } from 'axios';
import { FormError } from '../form/error';
import { useUrlState } from '../../hooks/useUrlState';

const questionComponentByType: Record<QuestionType, React.FC<any>> = {
    [QuestionType.OneCorrect]: QuestionOneCorrect,
    [QuestionType.MultipleCorrect]: () => <></>,
    [QuestionType.Match]: () => <></>,
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
}

export const QuestionEditComponent: React.FC<Props> = ({ initialQuestion, onSave }) => {

    const create = !initialQuestion;
    const action = create ? `/api/test/${location.pathname.split('/')[2]}/question` : `/question/${initialQuestion.id}`;
    const method = create ? 'POST' : 'PUT';

    const [question, setQuestion] = useState(initialQuestion ?? defaultQuestion);

    const [{ type }, setUrlData] = useUrlState<UrlData>({ type: question?.type ?? QuestionType.OneCorrect });
    const [error, setError] = useState<ValidationError>();

    const Component = questionComponentByType[type];

    const onSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const response = await axios.postForm(action, event.target).catch((reason: AxiosError) => {
            if (reason.response && reason.response.status === 422) setError(reason.response.data as ValidationError);
        });
        if (!response) return;

        setUrlData({ type: undefined }, true);
        onSave(response.data);
    }

    return <div className='grid grid-cols-[auto_1fr] gap-4 bg-white border shadow-md p-4'>
        <div>
            { Object.values(QuestionType).filter((v) => typeof v !== 'number').map((key) => 
                <button
                    key={key}
                    className='block w-full p-1 my-2 bg-emerald-400 hover:bg-emerald-500 rounded'
                    onClick={() => setUrlData({ type: QuestionType[key] }, true)}
                > { QuestionTypeName[QuestionType[key]] } </button>
            )}
        </div>
        <div>
            <div className='text-2xl indent-1'>{ create ? 'Створити' : 'Редагувати' } питання</div>
            <form action={action} method='POST' encType='multipart/form-data' onSubmit={onSubmit}>
                <CSRF></CSRF>
                <Method method={method}></Method>
                <input type='hidden' name='type' value={ type } />
                <div className='grid grid-cols-[1fr_auto] mb-4'>
                    <div>
                        <label htmlFor='text'>Питання</label>
                        <EditorComponent name='text' id='text' placeholder='Питання'></EditorComponent>
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
                                        // setImg(undefined);
                                        setQuestion({ ...question, image: undefined });
                                        
                                        event.currentTarget.value = "";
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
                        <label htmlFor='text'>Опис</label>
                        <FormTextarea name='description' placeholder='Опис' />
                    </div>
                    <div>
                        <label htmlFor='points'>Бали</label>
                        <FormTextInput type='number' name='points' value={question?.points ?? 1} placeholder='Кількість балів'></FormTextInput>
                    </div>
                </div>
                <Component key={ type } initialOptions={ question.options }></Component>
                <FormSubmit>{ create ? 'Створити' : 'Зберегти' }</FormSubmit>
                <FormError error={error}></FormError>
            </form>
        </div>
    </div>
}