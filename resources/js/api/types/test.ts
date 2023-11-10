import { Accessibility } from './accessibility';
import { Course } from './course';
import { Grade } from './grade';
import { PickCond } from './pick';
import { Question } from './question';
import { Subject } from './subject';
import { User } from './user';

type Fields = {
    user: User;
    course?: Course;
    questions: Question[];
}

export type Test<T extends keyof Fields | '' = ''> = {
    id: number;
    name: string;
    image?: string;
    published: boolean;
    accessibility: Accessibility;
    description?: string;
    subject?: Subject;
    grade?: Grade;
} & PickCond<Fields, T>;