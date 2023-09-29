import { Course } from './course';
import { Grade } from './grade';
import { Question } from './question';
import { Subject } from './subject';
import { User } from './user';

export interface Test<T extends 'user' | 'course' | 'questions' | '' = ''> {
    id: number;
    name: string;
    image?: string;
    description?: string;
    subject: Subject;
    grade: Grade;
    user: [T] extends ['user'] ? User : undefined;
    course?: [T] extends ['course'] ? Course<'topics'> : undefined;
    questions: [T] extends ['questions'] ? Question[] : undefined;
}