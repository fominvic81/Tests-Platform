import axios from 'axios';
import { Course } from './types';


export const getCourse = async (id: string | number) => {
    const course = (await axios(`/api/course/${id}`)).data as Course;
    return course;
}