import axios from 'axios';
import { Test } from './types';


export const getTest = async (id: string | number) => {
    const test = (await axios(`/api/test/${id}`)).data as Test<'questions' | 'course'>;
    return test;
}