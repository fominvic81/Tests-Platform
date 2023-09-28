import { Grade } from './grade';
import { Question } from './question';
import { Subject } from './subject';



export interface Test {
    name: string;
    image?: string;
    description: string;
    subject: Subject;
    grade: Grade;
    questions: Question[];
}