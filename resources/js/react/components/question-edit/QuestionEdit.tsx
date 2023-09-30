import React, { useState } from 'react';
import { Question, QuestionType, QuestionTypeInitialData, QuestionTypeName } from '../../../api';
import { QuestionOneCorrect } from './OneCorrect';
import { CSRF, Method } from '../../utils';

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

interface Props {
    question?: Question;
}

export const QuestionEditComponent: React.FC<Props> = ({ question }) => {

    const create = !question;
    const action = create ? `/test/${location.pathname.split('/')[2]}/question` : `/question/${question.id}`;
    const method = create ? 'POST' : 'PUT';

    const [image, setImg] = useState(question?.image);
    const [type, setType] = useState(question?.type ?? QuestionType.OneCorrect);

    const Component = questionComponentByType[type];

    return <div className='grid grid-cols-[auto_1fr] gap-4 bg-white border shadow-md p-4'>
        <div>
            { Object.values(QuestionType).filter((v) => typeof v !== 'number').map((key) => 
                <button
                    key={key}
                    // className='block w-full p-1 my-2 bg-yellow-400 hover:bg-sky-600 rounded'
                    // className='block w-full p-1 my-2 bg-amber-400 hover:bg-sky-600 rounded'
                    className='block w-full p-1 my-2 bg-emerald-400 hover:bg-emerald-500 rounded'
                    onClick={() => setType(QuestionType[key])}
                > { QuestionTypeName[QuestionType[key]] } </button>
            )}
        </div>
        <div>
            <div className='text-2xl indent-1'>{ create ? 'Створити' : 'Редагувати' } питання</div>
            <form action={action} method='POST'>
                <CSRF></CSRF>
                <Method method={method}></Method>
                <input type='hidden' name='type' value={ type } />
                <div className='grid grid-cols-[1fr_auto]'>
                    <div>
                        <label htmlFor='text'>Питання</label>
                        <input type='text' name='text' id='text' defaultValue={ question?.text } placeholder='Питання' className='block border bg-gray-50 indent-1 h-8 w-full' />
                    </div>
                    <div className='w-48 row-span-6'>
                        <div className='aspect-square mx-3 mt-6 border'>
                            <label htmlFor={image ? 'image-delete' : 'image-upload'} className='w-full h-full relative flex items-center justify-center'>
                                <img className='max-w-full max-h-full' src={ image ?? '/images/add-image.png' } alt='Зоображення' />
                                <div className='absolute w-full py-2 text-center bottom-0 bg-gray-200 bg-opacity-40 border-t'>{image ? 'Видалити' : 'Додати зображення'}</div>
                            </label>
                            <button type='button' id='image-delete' onClick={() => setImg(undefined)} className='hidden'></button>
                            <input
                                type='file'
                                accept='image/*'
                                id='image-upload'
                                className='hidden'
                                onChange={(event) => {
                                    const file = event.target.files?.item(0);
                                    if (file) setImg(URL.createObjectURL(file));
                                }}
                            />
                        </div>
                    </div>
                    <div>
                        <label htmlFor='text'>Опис</label>
                        <textarea name='description' id='description' placeholder='Опис' className='block border bg-gray-50 indent-1 w-full' />
                    </div>
                    <div>
                        <label htmlFor='points'>Бали</label>
                        <input type='number' name='points' id='points' placeholder='Кількість балів' defaultValue={question?.points ?? 1} className='block border bg-gray-50 indent-1 h-8 w-full' />
                    </div>
                </div>
                <div className='w-full'></div>
                <Component type={ type }></Component>
                <button type='submit' className='w-full bg-sky-500 p-2 rounded'>{ create ? 'Створити' : 'Зберегти' }</button>
            </form>
        </div>
    </div>
}