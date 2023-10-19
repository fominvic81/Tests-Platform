import { Accessibility } from './accessibility';
import { PickCond } from './pick';
import { Test } from './test';
import { Topic } from './topic';
import { User } from './user';

type Fields = {
    user: User;
    tests: Test[];
}

export type Course<T extends keyof Fields | '' = ''> = {
    id: number;
    name: string;
    image?: string;
    published: boolean;
    accessibility: Accessibility;
    description?: string;
    topics: Topic[];
} & PickCond<Fields, T>;