import { Question, QuestionType } from './question';

export interface Session {
    id: number;
    questions: Question<QuestionType, false>[];
}