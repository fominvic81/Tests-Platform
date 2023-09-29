import { Test } from './test';
import { Topic } from './topic';
import { User } from './user';

export interface Course<T extends 'topics' | 'tests' | 'user' | '' = ''> {
    id: number;
    name: string;
    image?: string;
    description?: string;
    user: [T] extends ['user'] ? User : undefined;
    topics: [T] extends ['topics'] ? Topic[] : undefined;
    tests: [T] extends ['tests'] ? Test[] : undefined;
}