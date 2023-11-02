import React, { useState } from 'react';
import { Question, QuestionType, QuestionTypeName, ValidationError, QuestionInitialData } from '../../../../api';
import { OneCorrect } from './OneCorrect';
import { CSRF, Method } from '../../../utils';
import { TextEditor } from '../../TextEditor';
import { FormTextInput } from '../../form/text';
import { FormSubmit } from '../../form/submit';
import axios, { AxiosError } from 'axios';
import { FormError } from '../../form/error';
import { useUrlState } from '../../../hooks/useUrlState';
import { MultipleCorrect } from './MultipleCorrect';
import { FormToggle } from '../../form/toggle';
import { Match } from './Match';
import cn from 'classnames';
import { FormImage } from '../../form/image';
import { imagePath } from '../../../../api/storagePath';
import { TextInput } from './TextInput';
import { Sequence } from './Sequence';

const questionComponentByType: Record<QuestionType, React.FC<any>> = {
    [QuestionType.OneCorrect]: OneCorrect,
    [QuestionType.MultipleCorrect]: MultipleCorrect,
    [QuestionType.Match]: Match,
    [QuestionType.TextInput]: TextInput,
    [QuestionType.Sequence]: Sequence,
    [QuestionType.TextGapsTextInput]: () => <></>,
    [QuestionType.TextGapsVariantSingleList]: () => <></>,
    [QuestionType.TextGapsVariantMultipleLists]: () => <></>,
} as const;

const defaultQuestion = (type: QuestionType): Question => {
    return {
        id: 0,
        type,
        text: '',
        points: 1,
        topics: [],
        data: QuestionInitialData[type],
    }
}

type UrlData = {
    type: QuestionType;
}

interface Props {
    initialQuestion?: Question;
    onSave: (question: Question) => any;
}

export const QuestionEdit: React.FC<Props> = ({ initialQuestion, onSave }) => {

    const create = !initialQuestion;
    const action = create ? `/api/test/${location.pathname.split('/')[2]}/question` : `/api/question/${initialQuestion.id}`;
    const method = create ? 'POST' : 'PUT';

    const [{ type }, setUrlData, resetUrlData] = useUrlState<UrlData>({ type: initialQuestion?.type ?? QuestionType.OneCorrect });
    const [question, setQuestion] = useState<Question<QuestionType>>((!initialQuestion || type !== initialQuestion.type) ? defaultQuestion(type) : initialQuestion);

    const [error, setError] = useState<ValidationError>();

    const setType = (newType: QuestionType) => {
        setQuestion(newType === initialQuestion?.type ? { ...initialQuestion } : { ...question, data: QuestionInitialData[newType]});
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
                    {Object.values(QuestionType).filter((v) => typeof v !== 'number').map((key) => 
                        <button
                            type='button'
                            key={ key }
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
                            <div className='aspect-square mx-3 mt-6'>
                                <FormImage
                                    name='image'
                                    nameDel='del_image'
                                    defaultSrc={ question.image && imagePath(question.image) }
                                ></FormImage>
                            </div>
                        </div>
                        <div>
                            <FormTextInput type='number' name='points' label='Бали' defaultValue={question?.points ?? 1} placeholder='Кількість балів'></FormTextInput>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div className='mt-1 p-2 border-2'>
                <Component question={ question }></Component>
            </div>
            <div className='grid grid-cols-2 items-baseline gap-2'>
                <button
                    type='button'
                    className='h-10 bg-gray-50 border rounded'
                    onClick={() => {
                        history.back();
                    }}
                >Назад</button>
                <FormSubmit>{ create ? 'Створити' : 'Зберегти' }</FormSubmit>
            </div>
            <FormError error={error}></FormError>
        </form>
    </div>
}