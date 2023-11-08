import { Question, QuestionType } from './question';

export interface Session {
    id: number;
    ends_at?: number;
    questions: Question<QuestionType, false>[];
}