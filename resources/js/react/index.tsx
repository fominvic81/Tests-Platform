export const questionCreateComponentId = 'question-create';
export const questionEditComponentId = 'question-edit';
export const testExaminatorComponentId = 'test-examinator';

if (document.getElementById(questionCreateComponentId)) import('./pages/questionCreate');
if (document.getElementById(questionEditComponentId)) import('./pages/questionEdit');
if (document.getElementById(testExaminatorComponentId)) import('./pages/testExaminator');