import { Course } from './course';
import { Grade } from './grade';
import { Question } from './question';
import { Subject } from './subject';
import { User } from './user';

export type Test<T extends 'user' | 'course' | 'questions'> = Omit<{
    id: number;
    name: string;
    image?: string;
    description?: string;
    subject: Subject;
    grade: Grade;
    user: User;
    course?: Course<'topics'>;
    questions: Question[];
}, T>;