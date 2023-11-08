import React, { useRef, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { TestingShowId } from '../..';
import { Async, CSRF, Method, useAsync } from '../../utils';
import { Answer, QuestionType, Session, ValidationError, getSession } from '../../../api';
import { useUrlState } from '../../hooks/useUrlState';
import axios, { AxiosError } from 'axios';
import { QuestionAsk } from '../../components/question/ask';
import { FormError } from '../../components/form/error';
import { Timer } from '../../components/common/Timer';
import cn from 'classnames';

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
    const [showSaved, setShowSaved] = useState(false);
    const timeoutId = useRef<NodeJS.Timeout>();

    const incrementIndex = (value: number) => {
        setUrlState({ question: Math.max(0, Math.min(session.questions.length - 1, questionIndex + value)) });
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

        setShowSaved(true);
        clearTimeout(timeoutId.current);
        timeoutId.current = setTimeout(() => {
            setShowSaved(false);
        }, 1000);

        setError(undefined);
        incrementIndex(1);
    }

    return <div className='w-screen min-h-screen bg-gray-100 text-xl grid md:grid-cols-[300px_1fr] grid-rows-[min-content_1fr]'>
        <div className='fixed w-full flex justify-center pointer-events-none'>
            <div className={cn('bg-yellow-300 p-2 rounded-lg transition-all', showSaved ? 'translate-y-4' : '-translate-y-full')}>Збережено!</div>
        </div>
        <div className='w-full h-14 col-span-full flex items-start justify-between bg-emerald-400 shadow-md'>
            <div className='my-auto ml-4 font-bold font-mono'>{ questionIndex + 1 }/{ session.questions.length }</div>
            <div>
                { session.ends_at && <Timer end={ session.ends_at * 1000 }></Timer> }
            </div>
            <form className='my-auto' method='POST'>
                <CSRF></CSRF>
                <Method method='DELETE'></Method>
                <button type='submit' className='px-3 py-2 mr-2 bg-red-500 rounded shadow hover:brightness-90'>Завершити</button>
            </form>
        </div>
        <div className='md:col-start-2 p-5'>
            <form onSubmit={ onSubmit }>
                <input type='hidden' name='question_id' value={ question.id } />
                <QuestionAsk key={ question.id } question={ question }></QuestionAsk>
                <FormError error={ error }></FormError>
                <div className='flex justify-center'>
                    <button className='p-2 px-20 mt-2 border bg-yellow-300 rounded hover:brightness-90'>Зберегти</button>
                </div>
            </form>
        </div>
        <div className='md:col-start-1 md:row-start-2 md:border-r-2 border-gray-300 bg-gray-200 h-full min-h-[150px]'>
            <div className='grid grid-cols-[repeat(auto-fit,40px)] gap-1 mx-2'>
                {session.questions.map((q, index) => <button
                    key={ index }
                    type='button'
                    className={cn('w-full aspect-square m-1 hover:brightness-90 rounded border-2 border-gray-600', index === questionIndex ? 'bg-sky-400' : q.data.answer ? 'bg-gray-400' : 'bg-white')}
                    onClick={() => {
                        setUrlState({ question: index });
                        setError(undefined);
                    }}
                >{ index + 1 }</button>)}
            </div>
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