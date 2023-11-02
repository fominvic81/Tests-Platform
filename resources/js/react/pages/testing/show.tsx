import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { TestingShowId } from '../..';
import { Async, useAsync } from '../../utils';
import { Answer, QuestionType, Session, ValidationError, getSession } from '../../../api';
import { useUrlState } from '../../hooks/useUrlState';
import LeftSvg from '../../../../svg/testing/left.svg?react';
import cn from 'classnames';
import axios, { AxiosError } from 'axios';
import { QuestionAsk } from '../../components/question/ask';
import { FormError } from '../../components/form/error';

type AsyncData = [Session];

type UrlData = {
    question: number;
}

const Component: React.FC = () => {

    const [error, setError] = useState<ValidationError>();
    const [initialSession] = useAsync() as AsyncData;
    const [session, setSession] = useState(initialSession);
    const [{ question: questionIndex }, setUrlState] = useUrlState<UrlData>({ question: 0 });
    const question = session.questions[questionIndex];

    const incrementIndex = (value: number) => {
        setUrlState({ question: (questionIndex + session.questions.length + value) % session.questions.length })
    }

    const onSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const response = await axios.postForm(`/api/session/${session.id}/answer`, event.target).catch((reason: AxiosError) => {
            if (reason.response && reason.response.status === 422) setError(reason.response.data as ValidationError);
        });
        if (!response) return;

        const answer = response.data as Answer<QuestionType>;

        setSession({
            ...session,
            questions: session.questions.map((q) => q === question ? { ...question, data: { ...question.data, answer }} : q),
        });

        setError(undefined);
        incrementIndex(1);
    }

    return <div className='w-screen min-h-screen bg-gray-100 flex flex-col items-center justify-between text-xl'>
        <div className='w-full max-w-2xl h-full grid grid-cols-[auto_1fr_auto] items-center'>
            <button className='row-start-1 col-start-1 h-full' onClick={() => incrementIndex(-1)}><LeftSvg className='w-8 stroke-gray-500'></LeftSvg></button>
            <button className='row-start-1 col-start-3 h-full' onClick={() => incrementIndex(1)}><LeftSvg className='w-8 stroke-gray-500 -scale-x-100'></LeftSvg></button>
            <form onSubmit={ onSubmit }>
                <input type='hidden' name='question_id' value={ question.id } />
                <div className='my-8 row-start-1 col-start-2 p-3 mx-1 bg-white rounded-md shadow-md'>
                    <div className='indent-4 font-bold'>Завдання №{ questionIndex + 1 }</div>
                    <hr className='my-1'></hr>
                    <QuestionAsk question={ question }></QuestionAsk>
                    <FormError error={ error }></FormError>
                    <div className='grid grid-cols-2 mt-3 gap-3'>
                        <button className='col-span-2 p-1 border bg-gray-50 rounded hover:brightness-90'>Зберегти</button>
                    </div>
                </div>
            </form>
        </div>
        <div className='flex gap-[1px] mb-16 shadow rounded-md overflow-clip border bg-gray-300'>
            {session.questions.map((q, index) => <button
                key={ index }
                type='button'
                className={cn('w-10 h-10 border-gray-300 hover:brightness-90', index === questionIndex ? 'bg-sky-400' : 'bg-white')}
                onClick={() => {
                    setUrlState({ question: index });
                }}
            >{ index + 1 }</button>)}
        </div>
    </div>;
}

const root = createRoot(document.getElementById(TestingShowId)!);

root.render(
    <React.StrictMode>
        <Async loader={() => Promise.all([getSession(location.pathname.split('/')[2])])}>
            <Component></Component>
        </Async>
    </React.StrictMode>
);