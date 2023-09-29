import { Course } from './course';
import { Grade } from './grade';
import { Subject } from './subject';


export interface TestOptions {
    subjects: Subject[];
    grades: Grade[];
    courses: Course[];
}